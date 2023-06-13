<div>
    <!-- conversation -->
    <div id="users-chat" class="position-relative">
        <div class="p-3 p-lg-4 user-chat-topbar">
            @isset($group)
                @livewire('user-chat.topbar', compact('group'), key("topbar-{$group->id}"))
            @endisset
        </div>
        <!-- end chat user head -->

        <!-- start chat conversation -->

        <div class="chat-conversation p-3 p-lg-4 overflow-auto" id="chat-conversation">
            @isset($group)
                @livewire('user-chat.conversation', compact('group'), key("conversation-{$group->id}"))
            @endisset
        </div>

        <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show d-none" id="copyClipBoard" role="alert">
            message copied
        </div>


        <!-- end chat conversation end -->
    </div>

    <!-- start chat input section -->
    @isset($group)
        @livewire('user-chat.input', compact('group'), key("input-{$group->id}"))
    @endisset
    <!-- end chat input section -->
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

        Livewire.on('focusOnChatInput', function() {
            document.getElementById('chat-input').focus();
        });
    </script>
@endpush
