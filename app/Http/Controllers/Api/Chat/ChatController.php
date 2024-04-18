<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//model
use App\Models\ChatList;
use App\Models\ChatRoom;
use App\Models\ChatHistory;

class ChatController extends Controller
{
    public function CreateRoomChat(Request $request) {

        $messages = [
            'other_user_id.required' => 'Pasangan chat id required.',
        ];

        $validator = Validator::make($request->all(), [
            'other_user_id' => 'required|exists:users,id', 
        ], $messages);
        
        if ($validator->fails()) {
            return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => $request->other_user_id], 400);
        }

        try {
            
            //check room sebelumnya
            $existingChatList = ChatList::where('user_id', auth()->user()->id)
                                        ->whereHas('chatRoom', function($query) use ($request) {
                                            $query->whereHas('chatLists', function($subQuery) use ($request) {
                                                $subQuery->where('user_id', $request->other_user_id);
                                            });
                                        })
                                        ->first();

            if ($existingChatList) {
                // Jika sudah ada ruang obrolan yang menghubungkan kedua pengguna, gunakan ruang obrolan yang sudah ada
                return response()->json(['message' => 'Chat room already exists', 'data' => $existingChatList->chatRoom], 200);
            }

            // create room jika tidak ada room sebelumnya
            $chatRoom = ChatRoom::create([
                'user_id' => auth()->user()->id,
                'name' => 'room-with-'.auth()->user()->id,
            ]);

            // Tambahkan kedua pengguna ke dalam ruang obrolan baru
            $chatRoom->chatLists()->createMany([
                ['user_id' => auth()->user()->id],
                ['user_id' => $request->other_user_id],
            ]);

            return response()->json(["status" => "success", 'message' => 'Chat room created successfully', 'data' => $chatRoom], 201);
        
        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function SendOneMessage(Request $request){

        $messages = [
            'chat_list_id.required' => 'Chat list required.',
            'message_content.required' => 'Chat required.',
        ];

        $validator = Validator::make($request->all(), [
            'chat_list_id' => 'required|exists:a_chat_list,id',
            'message_content' => 'required|string',
        ], $messages);
        
        if ($validator->fails()) {
            return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => $request->message_content], 400);
        }

        try {
            $message = ChatHistory::create([
                'chat_list_id' => $request->chat_list_id,
                'sender_id' => auth()->user()->id, // pengguna yang terautentikasi sebagai pengirim
                'message_content' => $request->message_content,
            ]);

            return response()->json(["status" => "success", 'message' => 'Message sent successfully', 'data' => $message], 201);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function ChatHistory($chat_list_id){
    
        try {
         
            $chatHistory = ChatHistory::where('chat_list_id', $chat_list_id)
                ->orderBy('created_at', 'asc') //  urutan berdasarkan waktu dibuat
                ->get();

            return response()->json(["status" => "success", 'message' => 'Message history list retrieved', 'data' => $chatHistory], 201);
        
        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
        
    }

    public function getHistoryByRoom($room_id){

        try {

            $chatHistory = ChatHistory::whereHas('chatList', function ($query) use ($room_id) {
                    $query->where('chat_room_id', $room_id);
                })
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json(["status" => "success", 'message' => 'Message history list by room retrieved', 'data' => $chatHistory], 201);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
        
    }

}
