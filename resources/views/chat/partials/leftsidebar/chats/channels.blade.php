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
            @include('chat.partials.leftsidebar.chats.chat-list', ['dataName' => 'channel'])
        </ul>
    </div>
</div>
