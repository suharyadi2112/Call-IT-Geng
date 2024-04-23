@extends('partial.layout.main')
@section('title', 'Detail Pesan Masuk')
@section('content')
{{-- <div class="main-panel"> --}}
    <div class="">
        <div class="page-wrapper has-sidebar">
            <div class="page-inner page-inner-fill">
                <div class="conversations">
                    <div class="message-header">
                        <div class="message-title">
                            <a class="btn btn-light" href="messages.html">
                                <i class="fa fa-flip-horizontal fa-share"></i>
                            </a>
                            <div class="user ml-2">
                                <div class="avatar avatar-offline">
                                    <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                </div>
                                <div class="info-user ml-2">
                                    <span class="name">Chad</span>
                                    <span class="last-active">Active 2h ago</span>
                                </div>
                            </div>
                            <div class="ml-auto">
                                <button class="btn btn-light">
                                    <i class="fa fa-user-plus"></i>
                                </button>
                                <button class="btn btn-light page-sidebar-toggler d-xl-none">
                                    <i class="fa fa-angle-double-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="conversations-body">
                        <div class="conversations-content bg-white">
                            <div class="message-content-wrapper">
                                <div class="message message-in">
                                    <div class="avatar avatar-sm">
                                        <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                    </div>
                                    <div class="message-body">
                                        <div class="message-content">
                                            <div class="name">Chad</div>
                                            <div class="content">Hello, Rian</div>
                                        </div>
                                        <div class="date">12.31</div>
                                    </div>
                                </div>
                            </div>
                            <div class="message-content-wrapper">
                                <div class="message message-out">
                                    <div class="message-body">
                                        <div class="message-content">
                                            <div class="content">
                                                Hello, Chad
                                            </div>
                                        </div>
                                        <div class="message-content">
                                            <div class="content">
                                                What's up?
                                            </div>
                                        </div>
                                        <div class="date">12.35</div>
                                    </div>
                                </div>
                            </div>
                            <div class="message-content-wrapper">
                                <div class="message message-in">
                                    <div class="avatar avatar-sm">
                                        <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                    </div>
                                    <div class="message-body">
                                        <div class="message-content">
                                            <div class="name">Chad</div>
                                            <div class="content">
                                                Thanks
                                            </div>
                                        </div>
                                        <div class="message-content">
                                            <div class="content">
                                                When is the deadline of the project we are working on ?
                                            </div>
                                        </div>
                                        <div class="date">13.00</div>
                                    </div>
                                </div>
                            </div>
                            <div class="message-content-wrapper">
                                <div class="message message-out">
                                    <div class="message-body">
                                        <div class="message-content">
                                            <div class="content">
                                                The deadline is about 2 months away
                                            </div>
                                        </div>
                                        <div class="date">13.10</div>
                                    </div>
                                </div>
                            </div>
                            <div class="message-content-wrapper">
                                <div class="message message-in">
                                    <div class="avatar avatar-sm">
                                        <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                    </div>
                                    <div class="message-body">
                                        <div class="message-content">
                                            <div class="name">Chad</div>
                                            <div class="content">
                                                Ok, Thanks !
                                            </div>
                                        </div>
                                        <div class="date">13.15</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="messages-form">
                        <div class="messages-form-control">
                            <input type="text" placeholder="Type here" class="form-control input-pill input-solid message-input">
                        </div>
                        <div class="messages-form-tool">
                            <a href="#" class="attachment">
                                <i class="flaticon-file"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-sidebar">
                <header class="sidebar-header d-xl-none">
                    <a class="back">
                        <i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Back
                    </a>
                </header>
                <div class="page-sidebar-section pb-3">
                    <div class="page-navs bg-white mb-4">
                        <div class="nav-scroller">
                            <div class="nav nav-tabs nav-line nav-color-secondary">
                                <a class="nav-link active show" data-toggle="tab" href="#tab1">Contact Info
                                </a>
                                <a class="nav-link" data-toggle="tab" href="#tab2">Media</a>
                                <a class="nav-link" data-toggle="tab" href="#tab3">Action</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="avatar avatar-xxl mb-3">
                            <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                        </div>
                        <h4 class="fw-bold">Chad</h4>
                        <h6 class="text-muted mb-3">Banda Aceh . Since Jun 12, 2018</h6>
                        <div class="row m-0">
                            <div class="col-4">
                                <div class="metric">
                                    <h4 class="metric-value fw-bold">125</h4>
                                    <p class="metric-label fw-bold">Post</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="metric">
                                    <h4 class="metric-value fw-bold">25K</h4>
                                    <p class="metric-label fw-bold">Followers</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="metric">
                                    <h4 class="metric-value fw-bold">134</h4>
                                    <p class="metric-label fw-bold">Following</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group list-group-file-item list-group-reflow list-group-flush list-group-divider mt-3">
                        <!-- .list-group-header -->
                        <div class="list-group-header"> Today </div>
                        <!-- /.list-group-header -->
                        <!-- .list-group-item -->
                        <div class="list-group-item align-items-start">
                            <div class="list-group-item-figure">
                                <a href="#" class="tile tile-circle bg-primary">
                                    <span class="fa fa-file-pdf"></span>
                                </a>
                            </div>
                            <div class="list-group-item-body">
                                <h4 class="list-group-item-title text-truncate">
                                    <a href="#">pengertian-agregat.pdf</a>
                                </h4>
                                <p class="list-group-item-text"> 1.08 MB by Emma Stone </p>
                                <p class="list-group-item-text small"> 11:40pm </p>
                            </div>
                            <div class="list-group-item-figure">
                                <button class="btn btn-sm btn-light">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.list-group-item -->
                        <!-- .list-group-item -->
                        <div class="list-group-item align-items-start">
                            <div class="list-group-item-figure">
                                <a href="#" class="tile tile-circle bg-primary">
                                    <span class="fa fa-file-pdf"></span>
                                </a>
                            </div>
                            <div class="list-group-item-body">
                                <h4 class="list-group-item-title text-truncate">
                                    <a href="#">Baked-Chicken-and-Spinach-Flautas.pdf</a>
                                </h4>
                                <p class="list-group-item-text"> 0.39 MB by Peter Willis </p>
                                <p class="list-group-item-text small"> 5:22pm </p>
                            </div>
                            <div class="list-group-item-figure">
                                <button class="btn btn-sm btn-light">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.list-group-item -->
                        <!-- .list-group-item -->
                        <div class="list-group-item align-items-start">
                            <div class="list-group-item-figure">
                                <a href="#" class="tile tile-circle bg-danger">
                                    <span class="fa fa-file-image"></span>
                                </a>
                            </div>
                            <div class="list-group-item-body">
                                <h4 class="list-group-item-title text-truncate">
                                    <a href="#">Cajun Chicken Egg Pasta.jpg</a>
                                </h4>
                                <p class="list-group-item-text"> 0.93 MB by Danielle Garza </p>
                                <p class="list-group-item-text small"> 9:32pm </p>
                            </div>
                            <div class="list-group-item-figure">
                                <button class="btn btn-sm btn-light">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.list-group-item -->
                        <!-- .list-group-header -->
                        <div class="list-group-header"> Jan 28, 2018 </div>
                        <!-- /.list-group-header -->
                        <!-- .list-group-item -->
                        <div class="list-group-item align-items-start">
                            <div class="list-group-item-figure">
                                <a href="#" class="tile tile-circle bg-secondary">
                                    <span class="fa fa-file-archive"></span>
                                </a>
                            </div>
                            <div class="list-group-item-body">
                                <h4 class="list-group-item-title text-truncate">
                                    <a href="#">Atlantis_regular.zip</a>
                                </h4>
                                <p class="list-group-item-text"> 0.53 MB by Jimmy Chad </p>
                                <p class="list-group-item-text small"> 3:13am </p>
                            </div>
                            <div class="list-group-item-figure">
                                <button class="btn btn-sm btn-light">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.list-group-item -->
                        <!-- .list-group-item -->
                        <div class="list-group-item align-items-start">
                            <div class="list-group-item-figure">
                                <a href="#" class="tile tile-circle bg-secondary">
                                    <span class="fa fa-file-archive"></span>
                                </a>
                            </div>
                            <div class="list-group-item-body">
                                <h4 class="list-group-item-title text-truncate">
                                    <a href="#">Atlantis_extended.zip</a>
                                </h4>
                                <p class="list-group-item-text"> 2.04 MB by John Doe </p>
                                <p class="list-group-item-text small"> 11:27pm </p>
                            </div>
                            <div class="list-group-item-figure">
                                <button class="btn btn-sm btn-light">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.list-group-item -->
                        <!-- .list-group-header -->
                        <div class="list-group-header"> Jan 21, 2018 </div>
                        <!-- /.list-group-header -->
                        <!-- .list-group-item -->
                        <div class="list-group-item align-items-start">
                            <div class="list-group-item-figure">
                                <a href="#" class="tile tile-circle bg-primary">
                                    <span class="fa fa-file-pdf"></span>
                                </a>
                            </div>
                            <div class="list-group-item-body">
                                <h4 class="list-group-item-title text-truncate">
                                    <a href="#">Usulan Beasiswa Tahun 2018.pdf</a>
                                </h4>
                                <p class="list-group-item-text"> 1.1 MB by Peter Willis </p>
                                <p class="list-group-item-text small"> 6:20pm </p>
                            </div>
                            <div class="list-group-item-figure">
                                <button class="btn btn-sm btn-light">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.list-group-item -->
                        <!-- .list-group-item -->
                        <div class="list-group-item align-items-start">
                            <div class="list-group-item-figure">
                                <a href="#" class="tile tile-circle bg-success">
                                    <span class="fa fa-file-excel"></span>
                                </a>
                            </div>
                            <div class="list-group-item-body">
                                <h4 class="list-group-item-title text-truncate">
                                    <a href="#">Daftar Peserta Ujian.xlsx</a>
                                </h4>
                                <p class="list-group-item-text"> 0.37 MB by Peter Willis </p>
                                <p class="list-group-item-text small"> 1:32pm </p>
                            </div>
                            <div class="list-group-item-figure">
                                <button class="btn btn-sm btn-light">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.list-group-item -->
                        <!-- .list-group-item -->
                        <div class="list-group-item align-items-start">
                            <div class="list-group-item-figure">
                                <a href="#" class="tile tile-circle bg-info">
                                    <span class="fa fa-file-word"></span>
                                </a>
                            </div>
                            <div class="list-group-item-body">
                                <h4 class="list-group-item-title text-truncate">
                                    <a href="#">data_not_verified.docx</a>
                                </h4>
                                <p class="list-group-item-text"> 0.94 MB by Kathryn Black </p>
                                <p class="list-group-item-text small"> 5:11am </p>
                            </div>
                            <div class="list-group-item-figure">
                                <button class="btn btn-sm btn-light">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.list-group-item -->
                        <!-- .list-group-header -->
                        <div class="list-group-header"> Jan 19, 2018 </div>
                        <!-- /.list-group-header -->
                        <!-- .list-group-item -->
                        <div class="list-group-item align-items-start">
                            <div class="list-group-item-figure">
                                <a href="#" class="tile tile-circle bg-warning">
                                    <span class="fa fa-file-powerpoint"></span>
                                </a>
                            </div>
                            <div class="list-group-item-body">
                                <h4 class="list-group-item-title text-truncate">
                                    <a href="#">mockup-presentation.pptx</a>
                                </h4>
                                <p class="list-group-item-text"> 0.59 MB by Kathryn Black </p>
                                <p class="list-group-item-text small"> 6:50am </p>
                            </div>
                            <div class="list-group-item-figure">
                                <button class="btn btn-sm btn-light">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.list-group-item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
<div class="quick-sidebar">
    <a href="#" class="close-quick-sidebar">
        <i class="flaticon-cross"></i>
    </a>
    <div class="quick-sidebar-wrapper">
        <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
            <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#messages" role="tab" aria-selected="true">Messages</a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tasks" role="tab" aria-selected="false">Tasks</a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab" aria-selected="false">Settings</a> </li>
        </ul>
        <div class="tab-content mt-3">
            <div class="tab-chat tab-pane fade show active" id="messages" role="tabpanel">
                <div class="messages-contact">
                    <div class="quick-wrapper">
                        <div class="quick-scroll scrollbar-outer">
                            <div class="quick-content contact-content">
                                <span class="category-title mt-0">Contacts</span>
                                <div class="avatar-group">
                                    <div class="avatar">
                                        <img src="../assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                    </div>
                                    <div class="avatar">
                                        <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                    </div>
                                    <div class="avatar">
                                        <img src="../assets/img/mlane.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                    </div>
                                    <div class="avatar">
                                        <img src="../assets/img/talha.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                    </div>
                                    <div class="avatar">
                                        <span class="avatar-title rounded-circle border border-white">+</span>
                                    </div>
                                </div>
                                <span class="category-title">Recent</span>
                                <div class="contact-list contact-list-recent">
                                    <div class="user">
                                        <a href="#">
                                            <div class="avatar avatar-online">
                                                <img src="../assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                            </div>
                                            <div class="user-data">
                                                <span class="name">Jimmy Denis</span>
                                                <span class="message">How are you ?</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="user">
                                        <a href="#">
                                            <div class="avatar avatar-offline">
                                                <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                            </div>
                                            <div class="user-data">
                                                <span class="name">Chad</span>
                                                <span class="message">Ok, Thanks !</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="user">
                                        <a href="#">
                                            <div class="avatar avatar-offline">
                                                <img src="../assets/img/mlane.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                            </div>
                                            <div class="user-data">
                                                <span class="name">John Doe</span>
                                                <span class="message">Ready for the meeting today with...</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <span class="category-title">Other Contacts</span>
                                <div class="contact-list">
                                    <div class="user">
                                        <a href="#">
                                            <div class="avatar avatar-online">
                                                <img src="../assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                            </div>
                                            <div class="user-data2">
                                                <span class="name">Jimmy Denis</span>
                                                <span class="status">Online</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="user">
                                        <a href="#">
                                            <div class="avatar avatar-offline">
                                                <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                            </div>
                                            <div class="user-data2">
                                                <span class="name">Chad</span>
                                                <span class="status">Active 2h ago</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="user">
                                        <a href="#">
                                            <div class="avatar avatar-away">
                                                <img src="../assets/img/talha.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                            </div>
                                            <div class="user-data2">
                                                <span class="name">Talha</span>
                                                <span class="status">Away</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="messages-wrapper">
                    <div class="messages-title">
                        <div class="user">
                            <div class="avatar avatar-offline float-right ml-2">
                                <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                            </div>
                            <span class="name">Chad</span>
                            <span class="last-active">Active 2h ago</span>
                        </div>
                        <button class="return">
                            <i class="flaticon-left-arrow-3"></i>
                        </button>
                    </div>
                    <div class="messages-body messages-scroll scrollbar-outer">
                        <div class="message-content-wrapper">
                            <div class="message message-in">
                                <div class="avatar avatar-sm">
                                    <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                </div>
                                <div class="message-body">
                                    <div class="message-content">
                                        <div class="name">Chad</div>
                                        <div class="content">Hello, Rian</div>
                                    </div>
                                    <div class="date">12.31</div>
                                </div>
                            </div>
                        </div>
                        <div class="message-content-wrapper">
                            <div class="message message-out">
                                <div class="message-body">
                                    <div class="message-content">
                                        <div class="content">
                                            Hello, Chad
                                        </div>
                                    </div>
                                    <div class="message-content">
                                        <div class="content">
                                            What's up?
                                        </div>
                                    </div>
                                    <div class="date">12.35</div>
                                </div>
                            </div>
                        </div>
                        <div class="message-content-wrapper">
                            <div class="message message-in">
                                <div class="avatar avatar-sm">
                                    <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                </div>
                                <div class="message-body">
                                    <div class="message-content">
                                        <div class="name">Chad</div>
                                        <div class="content">
                                            Thanks
                                        </div>
                                    </div>
                                    <div class="message-content">
                                        <div class="content">
                                            When is the deadline of the project we are working on ?
                                        </div>
                                    </div>
                                    <div class="date">13.00</div>
                                </div>
                            </div>
                        </div>
                        <div class="message-content-wrapper">
                            <div class="message message-out">
                                <div class="message-body">
                                    <div class="message-content">
                                        <div class="content">
                                            The deadline is about 2 months away
                                        </div>
                                    </div>
                                    <div class="date">13.10</div>
                                </div>
                            </div>
                        </div>
                        <div class="message-content-wrapper">
                            <div class="message message-in">
                                <div class="avatar avatar-sm">
                                    <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
                                </div>
                                <div class="message-body">
                                    <div class="message-content">
                                        <div class="name">Chad</div>
                                        <div class="content">
                                            Ok, Thanks !
                                        </div>
                                    </div>
                                    <div class="date">13.15</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="messages-form">
                        <div class="messages-form-control">
                            <input type="text" placeholder="Type here" class="form-control input-pill input-solid message-input">
                        </div>
                        <div class="messages-form-tool">
                            <a href="#" class="attachment">
                                <i class="flaticon-file"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tasks" role="tabpanel">
                <div class="quick-wrapper tasks-wrapper">
                    <div class="tasks-scroll scrollbar-outer">
                        <div class="tasks-content">
                            <span class="category-title mt-0">Today</span>
                            <ul class="tasks-list">
                                <li>
                                    <label class="custom-checkbox custom-control checkbox-secondary">
                                        <input type="checkbox" checked="" class="custom-control-input"><span class="custom-control-label">Planning new project structure</span>
                                        <span class="task-action">
                                            <a href="#" class="link text-danger">
                                                <i class="flaticon-interface-5"></i>
                                            </a>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-checkbox custom-control checkbox-secondary">
                                        <input type="checkbox" class="custom-control-input"><span class="custom-control-label">Create the main structure							</span>
                                        <span class="task-action">
                                            <a href="#" class="link text-danger">
                                                <i class="flaticon-interface-5"></i>
                                            </a>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-checkbox custom-control checkbox-secondary">
                                        <input type="checkbox" class="custom-control-input"><span class="custom-control-label">Add new Post</span>
                                        <span class="task-action">
                                            <a href="#" class="link text-danger">
                                                <i class="flaticon-interface-5"></i>
                                            </a>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-checkbox custom-control checkbox-secondary">
                                        <input type="checkbox" class="custom-control-input"><span class="custom-control-label">Finalise the design proposal</span>
                                        <span class="task-action">
                                            <a href="#" class="link text-danger">
                                                <i class="flaticon-interface-5"></i>
                                            </a>
                                        </span>
                                    </label>
                                </li>
                            </ul>

                            <span class="category-title">Tomorrow</span>
                            <ul class="tasks-list">
                                <li>
                                    <label class="custom-checkbox custom-control checkbox-secondary">
                                        <input type="checkbox" class="custom-control-input"><span class="custom-control-label">Initialize the project							</span>
                                        <span class="task-action">
                                            <a href="#" class="link text-danger">
                                                <i class="flaticon-interface-5"></i>
                                            </a>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-checkbox custom-control checkbox-secondary">
                                        <input type="checkbox" class="custom-control-input"><span class="custom-control-label">Create the main structure							</span>
                                        <span class="task-action">
                                            <a href="#" class="link text-danger">
                                                <i class="flaticon-interface-5"></i>
                                            </a>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-checkbox custom-control checkbox-secondary">
                                        <input type="checkbox" class="custom-control-input"><span class="custom-control-label">Updates changes to GitHub							</span>
                                        <span class="task-action">
                                            <a href="#" class="link text-danger">
                                                <i class="flaticon-interface-5"></i>
                                            </a>
                                        </span>
                                    </label>
                                </li>
                                <li>
                                    <label class="custom-checkbox custom-control checkbox-secondary">
                                        <input type="checkbox" class="custom-control-input"><span title="This task is too long to be displayed in a normal space!" class="custom-control-label">This task is too long to be displayed in a normal space!				</span>
                                        <span class="task-action">
                                            <a href="#" class="link text-danger">
                                                <i class="flaticon-interface-5"></i>
                                            </a>
                                        </span>
                                    </label>
                                </li>
                            </ul>

                            <div class="mt-3">
                                <div class="btn btn-primary btn-rounded btn-sm">
                                    <span class="btn-label">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    Add Task
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="settings" role="tabpanel">
                <div class="quick-wrapper settings-wrapper">
                    <div class="quick-scroll scrollbar-outer">
                        <div class="quick-content settings-content">

                            <span class="category-title mt-0">General Settings</span>
                            <ul class="settings-list">
                                <li>
                                    <span class="item-label">Enable Notifications</span>
                                    <div class="item-control">
                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-label">Signin with social media</span>
                                    <div class="item-control">
                                        <input type="checkbox" data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-label">Backup storage</span>
                                    <div class="item-control">
                                        <input type="checkbox" data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-label">SMS Alert</span>
                                    <div class="item-control">
                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
                                    </div>
                                </li>
                            </ul>

                            <span class="category-title mt-0">Notifications</span>
                            <ul class="settings-list">
                                <li>
                                    <span class="item-label">Email Notifications</span>
                                    <div class="item-control">
                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-label">New Comments</span>
                                    <div class="item-control">
                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-label">Chat Messages</span>
                                    <div class="item-control">
                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-label">Project Updates</span>
                                    <div class="item-control">
                                        <input type="checkbox" data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-label">New Tasks</span>
                                    <div class="item-control">
                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="primary" data-style="btn-round">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
@endpush

@push('script')

@endpush