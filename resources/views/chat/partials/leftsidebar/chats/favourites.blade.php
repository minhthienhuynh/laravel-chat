<div>
    <h5 class="mb-3 px-4 mt-4 font-size-11 text-muted text-uppercase">Favourites</h5>

    <div class="chat-message-list">

        <ul class="list-unstyled chat-list chat-user-list" id="favourite-users">
            @foreach($groups as $group)
                @php
                    $countUnread = auth()->user()->countUnread($group);
                    $user = $group->other_users->first();
                @endphp
                <li id="contact-id-{{ $user->id }}" data-name="favorite"
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
