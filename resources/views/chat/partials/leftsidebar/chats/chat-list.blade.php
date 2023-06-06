@foreach($groups as $group)
    @php($countUnread = auth()->user()->countUnread($group))
    <li id="contact-id-{{ $group->id }}" data-name="{{ $dataName }}"
        :class="{ 'active': contactSelected == {{ $group->id }} }">
        <a href="javascript: void(0);" class="@if($countUnread) unread-msg-user @endif"
           wire:click="$emit('contactSelected', {{ $group->id }})"
           @click="contactSelected = {{ $group->id }}; showUserChat = true">
            <div class="d-flex align-items-center">
                @if($group->type == $group::TYPE_USER)
                    @php($user = $group->other_users->first())
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
                @else
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
                @endif
            </div>
        </a>
    </li>
@endforeach
