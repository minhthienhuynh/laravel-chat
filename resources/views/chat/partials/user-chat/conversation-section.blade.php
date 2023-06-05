<div class="w-100 overflow-hidden position-relative">
    <!-- conversation -->
    <div class="position-relative">
        <div class="p-3 p-lg-4 user-chat-topbar">
            @livewire('user-chat.topbar')
        </div>
        <!-- end chat user head -->

        <!-- start chat conversation -->

        <div class="chat-conversation p-3 p-lg-4 " id="chat-conversation" data-simplebar>
            @livewire('user-chat.conversation')
        </div>

        <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show d-none" id="copyClipBoard" role="alert">
            message copied
        </div>


        <!-- end chat conversation end -->
    </div>

    <!-- start chat input section -->
    @livewire('user-chat.input')
    <!-- end chat input section -->
</div>
