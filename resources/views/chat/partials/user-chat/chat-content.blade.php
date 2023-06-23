<div>
    <div class="chat-content d-lg-flex"
         x-data="{ showProfileSidebar: false }">
        @isset($room)
            <!-- start chat conversation section -->
            <div class="w-100 overflow-hidden position-relative">
                <!-- conversation -->
                <div id="users-chat" class="position-relative">
                    <div class="p-3 p-lg-4 user-chat-topbar">
                        @livewire('user-chat.topbar', compact('room'), key("topbar-{$room->id}"))
                    </div>
                    <!-- end chat user head -->

                    <!-- start chat conversation -->
                    <div class="chat-conversation p-3 p-lg-4 overflow-auto" id="chat-conversation">
                        @livewire('user-chat.conversation', compact('room'), key("conversation-{$room->id}"))
                    </div>

                    <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show d-none" id="copyClipBoard" role="alert">
                        message copied
                    </div>
                    <!-- end chat conversation end -->
                </div>

                <!-- start chat input section -->
                @livewire('user-chat.input', compact('room'), key("input-{$room->id}"))
                <!-- end chat input section -->
            </div>
            <!-- end chat conversation section -->

            <!-- start User profile detail sidebar -->
            @livewire('user-chat.profile', compact('room', 'user'), key("profile-{$room->id}"))
            <!-- end User profile detail sidebar -->
        @endisset
    </div>
</div>

@push('modals')
    @livewire('user-chat.forward-modal')
@endpush

@push('scripts')
    <script>
        function scrollToBottom(id) {
            var simpleBar = document.getElementById(id).querySelector('#chat-conversation');
            var offsetHeight = document.getElementsByClassName('chat-conversation-list')[0]
                ? document.getElementById(id).getElementsByClassName('chat-conversation-list')[0].scrollHeight - window.innerHeight + 250
                : 0;
            if (offsetHeight) {
                simpleBar.scrollTo({ top: offsetHeight, behavior: 'smooth' });
            }
        }

        Livewire.on('scrollToBottom', () => {
            scrollToBottom('users-chat');
        });

        Livewire.on('focusOnChatInput', function () {
            document.getElementById('chat-input').focus();
        });

        Livewire.on('scrollToUnreadMessage', (id) => {
            if (! id) {
                id = $('#chat-conversation .chat-conversation-list').data('unread_from_message_id');
            }

            scrollToMessage(id, {});
        });

        Livewire.on('scrollToMessage', (id, options) => {
            scrollToMessage(id, options);
        });

        function scrollToMessage(id, options) {
            const element = document.getElementById(`message-${id}`);

            if (element) {
                element.scrollIntoView(options);
            }
        }
    </script>
@endpush
