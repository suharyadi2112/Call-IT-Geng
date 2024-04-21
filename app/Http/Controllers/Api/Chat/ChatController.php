<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
// event
use App\Events\ChatPengaduan;

//model
use App\Models\ChatList;
use App\Models\ChatRoom;
use App\Models\ChatHistory;
use App\Models\Pengaduan;

class ChatController extends Controller
{
    public function CreateRoomChat(Request $request) {

        $messages = [
            // 'other_user_id.required' => 'Pasangan chat id required.',
            'pengaduan_id.required' => 'Pengaduan id required.',
        ];

        $validator = Validator::make($request->all(), [
            'pengaduan_id' => 'required|exists:a_pengaduan,id', 
        ], $messages);

        $existingChatList = ChatList::where('user_id', auth()->user()->id)
        ->whereHas('chatRoom', function($query) use ($request) {
            $query->where('pengaduan_id', $request->pengaduan_id);
        })
        ->first();

        if ($existingChatList) {
            $validator->after(function ($validator) {
                $validator->errors()->add('exist room', 'Chat room with this pengaduan already exists.');
            });
        }
        
        if ($validator->fails()) {
            return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => $request->pengaduan_id], 400);
        }

        try {
            
            // create room dengan pengaduan id
            $dataS = null;
            DB::transaction(function () use ($request, &$dataS) {
                $pengaduan = Pengaduan::find($request->pengaduan_id);
                $workersInvolved = $pengaduan->workers->pluck('id');
                $members = $workersInvolved->push(auth()->id())->unique()->toArray();
                
                $chatRoom = ChatRoom::create([
                    'user_id' => auth()->user()->id,
                    'name' => 'room-with-'.auth()->user()->id,
                    'pengaduan_id' => $request->pengaduan_id,
                ]);
                
                $chatRoom->chatLists()->createMany(
                    array_map(function($member) {
                        return ['user_id' => $member];
                    }, $members)
                );

                $dataS = $chatRoom;
                
            });
            
             return response()->json(["status" => "success", 'message' => 'Chat room created successfully', 'data' => $dataS], 201);
        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function SendOneMessage(Request $request){

        $messages = [
            'message_content.required' => 'Chat required.',
            'roomID.required' => 'Chat Room ID required.',
        ];

        $validator = Validator::make($request->all(), [
            'message_content' => 'required|string',
            'roomID' => 'required|string',
        ], $messages);
        
        if ($validator->fails()) {
            return response()->json(["status"=> "fail", "message"=>  $validator->errors(),"data" => $request->message_content], 400);
        }

        try {

            $message = null;
            $message = ChatHistory::create([
                'chat_room_id' => $request->roomID,
                'sender_id' => auth()->user()->id, // pengguna yang terautentikasi sebagai pengirim
                'message_content' => $request->message_content,
            ]);

            //broadcast to all worker terkait pengaduan
            $workerOnRoom = ChatRoom::find($request->roomID);
            if ($workerOnRoom) {
                $pengaduanId = $workerOnRoom->pengaduan_id;
                $pengaduanWorker = Pengaduan::find($pengaduanId);
                if ($pengaduanWorker) {
                    $workersInvolved = $pengaduanWorker->workers->pluck('id');
                    $additionalWorkerIds = collect($workerOnRoom->user_id)->map(function ($id) {
                        return (int) $id; //ubah menjadi int
                    });
                    $members = $workersInvolved->merge($additionalWorkerIds)->unique();
                } else {
                    throw new \Exception('pengaduan not found');
                }
            } else {
                throw new \Exception('room not found');
            }

            $payloadBroad = [
                'roomID' => $request->roomID,
                'members' => $members,
                'sender_id' => $message->sender_id,
            ];

            //Event Kirim Pesan
            event(new ChatPengaduan($payloadBroad));
            
            return response()->json(["status" => "success", 'message' => 'Message sent successfully', 'data' => $message], 201);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
    }

    public function getHistoryByPengaduanID($pengaduan_id){

        try {
            
            $roomReady = ChatRoom::where('pengaduan_id', $pengaduan_id)->exists();

            $room = ChatRoom::where('pengaduan_id', $pengaduan_id)->first();
            $roomReady = $room ? true : false;

            $chatHistory = ChatHistory::whereHas('chatRoom', function ($query) use ($pengaduan_id) {
                $query->where('pengaduan_id', $pengaduan_id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

            $data = [
                'resultChat' => $chatHistory,
                'roomReady' => $roomReady,
                'roomID' => $room ? $room->id : null,
            ];
        
            return response()->json(["status" => "success", 'message' => 'Message history list by pengaduan retrieved', 'data' => $data], 201);

        } catch (\Exception $e) {
            return response(["status"=> "fail","message"=> $e->getMessage(),"data" => null], 500);
        }
        
    }

}
