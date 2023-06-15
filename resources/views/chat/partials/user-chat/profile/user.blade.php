<div class="p-3 border-bottom">
    <div class="user-profile-img">
        <img src="{{ $user->profile_photo_url }}" class="profile-img rounded" alt="{{ $user->name }}">
        <div class="overlay-content rounded">
            <div class="user-chat-nav p-2">
                <div class="d-flex w-100">
                    <div class="flex-grow-1">
                        <button type="button" class="btn nav-btn text-white user-profile-show d-none d-lg-block"
                                @click="showProfileSidebar = ! showProfileSidebar">
                            <i class="bx bx-x"></i>
                        </button>
                        <button type="button" class="btn nav-btn text-white user-profile-show d-block d-lg-none"
                                @click="showProfileSidebar = ! showProfileSidebar">
                            <i class="bx bx-left-arrow-alt"></i>
                        </button>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="dropdown">
                            <button class="btn nav-btn text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-dots-vertical-rounded'></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item d-flex justify-content-between align-items-center d-lg-none user-profile-show" href="#">View Profile <i class="bx bx-user text-muted"></i></a>
                                <a class="dropdown-item d-flex justify-content-between align-items-center d-lg-none" href="#" data-bs-toggle="modal" data-bs-target=".audiocallModal">Audio <i class="bx bxs-phone-call text-muted"></i></a>
                                <a class="dropdown-item d-flex justify-content-between align-items-center d-lg-none" href="#" data-bs-toggle="modal" data-bs-target=".videocallModal">Video <i class="bx bx-video text-muted"></i></a>
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Archive <i class="bx bx-archive text-muted"></i></a>
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Muted <i class="bx bx-microphone-off text-muted"></i></a>
                                <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Delete <i class="bx bx-trash text-muted"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-auto p-3">
                <h5 class="user-name mb-1 text-truncate">{{ $user->name }}</h5>
                <p class="font-size-14 text-truncate mb-0">
                    <i class="bx bxs-circle font-size-10 me-1 ms-0"
                       :class="{ 'text-success': onlineUsers.includes({{ $user->id }}) }"></i>
                    <span x-text="onlineUsers.includes({{ $user->id }}) ? 'Online' : 'Offline'"></span>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- End profile user -->

<!-- Start user-profile-desc -->
<div class="p-4 user-profile-desc" data-simplebar>

    <div class="text-center border-bottom">
        <div class="row">
            <div class="col-sm col-4">
                <div class="mb-4">
                    <button type="button" class="btn avatar-sm p-0">
                        <span class="avatar-title rounded bg-light text-body">
                            <i class="bx bxs-message-alt-detail"></i>
                        </span>
                    </button>
                    <h5 class="font-size-11 text-uppercase text-muted mt-2">Message</h5>
                </div>
            </div>
            <div class="col-sm col-4">
                <div class="mb-4">
                    @php($activeClass = in_array($room->id, auth()->user()->options['room-favorites']) ? 'active' : '')
                    <button type="button" class="btn avatar-sm p-0 favourite-btn {{ $activeClass }}"
                            wire:click="setFavourite({{ $room->id }})">
                        <span class="avatar-title rounded bg-light text-body">
                            <i class="bx bx-heart"></i>
                        </span>
                    </button>
                    <h5 class="font-size-11 text-uppercase text-muted mt-2">Favourite</h5>
                </div>
            </div>
            <div class="col-sm col-4">
                <div class="mb-4">
                    <button type="button" class="btn avatar-sm p-0" data-bs-toggle="modal" data-bs-target=".audiocallModal">
                        <span class="avatar-title rounded bg-light text-body">
                            <i class="bx bxs-phone-call"></i>
                        </span>
                    </button>
                    <h5 class="font-size-11 text-uppercase text-muted mt-2">Audio</h5>
                </div>
            </div>
            <div class="col-sm col-4">
                <div class="mb-4">
                    <button type="button" class="btn avatar-sm p-0" data-bs-toggle="modal" data-bs-target=".videocallModal">
                        <span class="avatar-title rounded bg-light text-body">
                            <i class="bx bx-video"></i>
                        </span>
                    </button>
                    <h5 class="font-size-11 text-uppercase text-muted mt-2">Video</h5>
                </div>
            </div>
            <div class="col-sm col-4">
                <div class="mb-4">
                    <div class="dropdown">
                        <button class="btn avatar-sm p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="avatar-title bg-light text-body rounded">
                                <i class='bx bx-dots-horizontal-rounded'></i>
                            </span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Archive <i class="bx bx-archive text-muted"></i></a>
                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Muted <i class="bx bx-microphone-off text-muted"></i></a>
                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Delete <i class="bx bx-trash text-muted"></i></a>
                        </div>
                    </div>
                    <h5 class="font-size-11 text-uppercase text-muted mt-2">More</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="text-muted pt-4">
        <h5 class="font-size-11 text-uppercase">Status :</h5>
        <p class="mb-4">If several languages coalesce, the grammar of the resulting.</p>
    </div>

    <div class="pb-2">
        <h5 class="font-size-11 text-uppercase mb-2">Info :</h5>
        <div>
            <div class="d-flex align-items-end">
                <div class="flex-grow-1">
                    <p class="text-muted font-size-14 mb-1">Name</p>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-sm btn-soft-primary">Edit</button>
                </div>
            </div>
            <h5 class="font-size-14 text-truncate">{{ $user->name }}</h5>
        </div>

        <div class="mt-4">
            <p class="text-muted font-size-14 mb-1">Email</p>
            <h5 class="font-size-14">{{ $user->email }}</h5>
        </div>
    </div>
    <hr class="my-4">

    <div>
        <div class="d-flex">
            <div class="flex-grow-1">
                <h5 class="font-size-11 text-muted text-uppercase">Group in common</h5>
            </div>
        </div>

        <ul class="list-unstyled chat-list mx-n4">
            @foreach($commonRooms as $room)
                <li>
                    <a href="javascript: void(0);"
                       @click="contactSelected = {{ $room->id }}"
                       wire:click="$emit('contactSelected', {{ $room->id }})">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 avatar-xs me-2">
                                <span class="avatar-title rounded-circle bg-soft-light text-dark">
                                    #
                                </span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate mb-0">{{ $room->name }}</p>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <hr class="my-4">
</div>
<!-- end user-profile-desc -->
