@foreach($rooms as $room)
    @php($countUnread = auth()->user()->countUnread($room))
    <li id="contact-id-{{ $room->id }}" data-name="{{ $dataName }}"
        :class="{ 'active': contactSelected == {{ $room->id }} }"
        x-init="
            Echo.join('chat.{{ $room->id }}')
                .here((users) => {
                    userIds = users.map(user => user.id);
                    onlineUsers = [...new Set(onlineUsers.concat(userIds))];
                })
                .joining((user) => {
                    onlineUsers.push(user.id);
                    onlineUsers = [...new Set(onlineUsers)];
                })
                .leaving((user) => {
                    onlineUsers = onlineUsers.filter(id => id !== user.id);
                })
                .listen('NewMessage', (e) => {
                    Livewire.emit('messageReceived', e.id, e.room_id);
                })
                .error((error) => {
                    console.error(error);
                });
        ">
        <a href="javascript: void(0);" class="@if($countUnread) unread-msg-user @endif"
           wire:click="$emit('contactSelected', {{ $room->id }})"
           @click="contactSelected = {{ $room->id }}; showUserChat = true">
            <div class="d-flex align-items-center">
                @if($room->type == $room::TYPE_USER)
                    @php($user = $room->other_users->first())
                    <div class="chat-user-img align-self-center me-2 ms-0"
                         :class="{ 'online': onlineUsers.includes({{ $user->id }}) }">
                        <img src="{{ $user->profile_photo_url }}" class="rounded-circle avatar-xs" alt="{{ $user->name }}">
                        @if ($user->status != $user::STATUS_INVISIBLE)
                            <span class="user-status {{ $user->getBGColor() }}"
                                  :class="{ 'd-none': ! onlineUsers.includes({{ $user->id }}) }"></span>
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
                        <p class="text-truncate mb-0">{{ $room->name }}</p>
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
