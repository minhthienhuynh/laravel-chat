<div>
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
                    :class="{ 'active': contactSelected == 'group-{{ $group->id }}' }">
                    <a href="javascript: void(0);" class="@if($countUnread) unread-msg-user @endif"
                       wire:click="$emitTo('user-chat.content', 'contactSelected', {{ $group->id }}, {{ $group::TYPE_GROUP }})"
                       @click="contactSelected = 'group-{{ $group->id }}'; showUserChat = true">
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
</div>
