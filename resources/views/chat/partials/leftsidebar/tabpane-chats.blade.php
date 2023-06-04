<div x-data="{ addGroupModal: new bootstrap.Modal(document.getElementById('addgroup-exampleModal')) }">
    <!-- Start chats content -->
    <div>
        <div class="px-4 pt-4">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1">
                    <h4 class="mb-4">Chats</h4>
                </div>
                <div class="flex-shrink-0">
                    <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Add Contact">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addContact-exampleModal">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <form>
                <div class="input-group mb-3">
                    <input type="text" class="form-control bg-light border-0 pe-0" id="serachChatUser" onkeyup="searchUser()" placeholder="Search here.."
                    aria-label="Example text with button addon" aria-describedby="searchbtn-addon" autocomplete="off">
                    <button class="btn btn-light" type="button" id="searchbtn-addon"><i class='bx bx-search align-middle'></i></button>
                </div>
            </form>

        </div> <!-- .p-4 -->

        <div class="chat-room-list" data-simplebar
             x-data="{ contactSelected: '' }">
            <!-- Start chat-message-list -->
            <h5 class="mb-3 px-4 mt-4 font-size-11 text-muted text-uppercase">Favourites</h5>

            <div class="chat-message-list">

                <ul class="list-unstyled chat-list chat-user-list" id="favourite-users">
                </ul>
            </div>

            <div class="d-flex align-items-center px-4 mt-5 mb-2">
                <div class="flex-grow-1">
                    <h4 class="mb-0 font-size-11 text-muted text-uppercase">Direct Messages</h4>
                </div>
                <div class="flex-shrink-0">
                    <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="New Message">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target=".contactModal">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="chat-message-list">

                <ul class="list-unstyled chat-list chat-user-list" id="usersList">
                    @foreach($users as $user)
                        @php($countUnread = auth()->user()->countUnread($user))
                        <li id="contact-id-{{ $user->id }}" data-name="favorite"
                            :class="{ 'active': contactSelected == 'user{{ $user->id }}' }">
                            <a href="javascript: void(0);" class="@if($countUnread) unread-msg-user @endif"
                               wire:click="$emitTo('user-chat.content', 'contactSelected', {{ $user->id }}, {{ \App\Models\Group::TYPE_USER }})"
                               @click="contactSelected = 'user{{ $user->id }}'; showUserChat = true">
                                <div class="d-flex align-items-center">
                                    <div class="chat-user-img online align-self-center me-2 ms-0">
                                        <img src="{{ $user->profile_photo_url }}" class="rounded-circle avatar-xs" alt="{{ $user->name }}">
                                        @if ($user->status != \App\Models\User::STATUS_INVISIBLE)
                                            <span class="user-status {{ $user->getBGColor() }}"></span>
                                        @endif
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-truncate mb-0">{{ $user->name }}</p>
                                    </div>
                                    @if ($countUnread > 0)
                                        <div class="ms-auto"><span class="badge badge-soft-dark rounded p-1">{{ $countUnread }}</span></div>
                                    @endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="d-flex align-items-center px-4 mt-5 mb-2">
                <div class="flex-grow-1">
                    <h4 class="mb-0 font-size-11 text-muted text-uppercase">Channels</h4>
                </div>
                <div class="flex-shrink-0">
                    <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Create group">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-soft-primary btn-sm"
                                @click="addGroupModal.show()">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="chat-message-list">

                <ul class="list-unstyled chat-list chat-user-list mb-3" id="channelList">
                    @foreach($groups as $group)
                        @php($countUnread = auth()->user()->countUnread($group))
                        <li id="contact-id-{{ $group->id }}" data-name="channel"
                            :class="{ 'active': contactSelected == 'group{{ $group->id }}' }">
                            <a href="javascript: void(0);" class="@if($countUnread) unread-msg-user @endif"
                               wire:click="$emitTo('user-chat.content', 'contactSelected', {{ $group->id }}, {{ \App\Models\Group::TYPE_GROUP }})"
                               @click="contactSelected = 'group{{ $group->id }}'; showUserChat = true">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs me-2">
                                        <span class="avatar-title rounded-circle bg-soft-light text-dark">#</span>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-truncate mb-0">{{ $group->name }}</p>
                                    </div>
                                    @if($countUnread)
                                        <div>
                                            <div class="flex-shrink-0 ms-2">
                                                <span class="badge badge-soft-dark rounded p-1">{{ $countUnread }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- End chat-message-list -->
        </div>

    </div>
    <!-- Start chats content -->

    @include('chat.partials.leftsidebar.add-group-modal')
</div>
