<div>
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
            @foreach($groups as $group)
                @php
                    $countUnread = auth()->user()->countUnread($group);
                    $user = $group->other_users->first();
                @endphp
                <li id="contact-id-{{ $user->id }}" data-name="direct-message"
                    :class="{ 'active': contactSelected == 'user-{{ $user->id }}' }">
                    <a href="javascript: void(0);" class="@if($countUnread) unread-msg-user @endif"
                       wire:click="$emit('contactSelected', {{ $group->id }})"
                       @click="contactSelected = 'user-{{ $user->id }}'; showUserChat = true">
                        <div class="d-flex align-items-center">
                            <div class="chat-user-img online align-self-center me-2 ms-0">
                                <img src="{{ $user->profile_photo_url }}" class="rounded-circle avatar-xs" alt="{{ $user->name }}">
                                @if ($user->status != $user::STATUS_INVISIBLE)
                                    <span class="user-status {{ $user->getBGColor() }}"></span>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-truncate mb-0">{{ $user->name }}</p>
                            </div>
                            @if ($countUnread)
                                <div class="ms-auto"><span class="badge badge-soft-dark rounded p-1">{{ $countUnread }}</span></div>
                            @endif
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
