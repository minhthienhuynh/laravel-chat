<div class="row align-items-center">
    <div class="col-sm-4 col-8">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0 d-block d-lg-none me-3">
                <a href="javascript: void(0);" class="user-chat-remove font-size-18 p-1"
                   @click="showUserChat = false"><i class="bx bx-chevron-left align-middle"></i></a>
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 chat-user-img user-own-img align-self-center me-3 ms-0"
                         :class="{ 'online': onlineUsers.includes({{ $user->id }}) }">
                        <img src="{{ $user->profile_photo_url }}" class="rounded-circle avatar-sm" alt="{{ $user->name }}">
                        @if ($user->status != $user::STATUS_INVISIBLE)
                            <span class="user-status {{ $user->getBGColor() }}"
                                  :class="{ 'd-none': ! onlineUsers.includes({{ $user->id }}) }"></span>
                        @endif
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h6 class="text-truncate mb-0 font-size-18"><a href="#" class="user-profile-show text-reset">{{ $user->name }}</a></h6>
                        <p class="text-truncate text-muted mb-0">
                            <small x-text="onlineUsers.includes({{ $user->id }}) ? 'Online' : 'Offline'"></small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8 col-4">
        <ul class="list-inline user-chat-nav text-end mb-0">
            <li class="list-inline-item">
                <div class="dropdown">
                    <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-search'></i>
                    </button>
                    <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                        <div class="search-box p-2">
                            <input type="text" class="form-control" placeholder="Search.." id="searchChatMessage">
                        </div>
                    </div>
                </div>
            </li>

            <li class="list-inline-item d-none d-lg-inline-block me-2 ms-0">
                <button type="button" class="btn nav-btn" data-bs-toggle="modal" data-bs-target=".audiocallModal">
                    <i class='bx bxs-phone-call' ></i>
                </button>
            </li>

            <li class="list-inline-item d-none d-lg-inline-block me-2 ms-0">
                <button type="button" class="btn nav-btn" data-bs-toggle="modal" data-bs-target=".videocallModal">
                    <i class='bx bx-video' ></i>
                </button>
            </li>

            <li class="list-inline-item d-none d-lg-inline-block me-2 ms-0">
                <button type="button" class="btn nav-btn user-profile-show"
                        @click="showProfileSidebar = ! showProfileSidebar">
                    <i class='bx bxs-info-circle' ></i>
                </button>
            </li>

            <li class="list-inline-item">
                <div class="dropdown">
                    <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-dots-vertical-rounded' ></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item d-flex justify-content-between align-items-center d-lg-none user-profile-show" href="#"
                           @click="showProfileSidebar = ! showProfileSidebar">View Profile <i class="bx bx-user text-muted"></i></a>
                        <a class="dropdown-item d-flex justify-content-between align-items-center d-lg-none" href="#" data-bs-toggle="modal" data-bs-target=".audiocallModal">Audio <i class="bx bxs-phone-call text-muted"></i></a>
                        <a class="dropdown-item d-flex justify-content-between align-items-center d-lg-none" href="#" data-bs-toggle="modal" data-bs-target=".videocallModal">Video <i class="bx bx-video text-muted"></i></a>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Archive <i class="bx bx-archive text-muted"></i></a>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="#">Muted <i class="bx bx-microphone-off text-muted"></i></a>
                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="#"
                           wire:click="$emitTo('user-chat.chat-content', 'userLeaving')">Delete <i class="bx bx-trash text-muted"></i></a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
