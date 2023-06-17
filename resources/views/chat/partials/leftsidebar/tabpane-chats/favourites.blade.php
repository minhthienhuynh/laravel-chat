<div>
    <div class="@if($rooms->isEmpty()) d-none @endif">
        <h5 class="mb-3 px-4 mt-4 font-size-11 text-muted text-uppercase">Favourites</h5>

        <div class="chat-message-list">

            <ul class="list-unstyled chat-list chat-user-list" id="favourite-users">
                @include('chat.partials.leftsidebar.tabpane-chats.chat-list', ['dataName' => 'favorite'])
            </ul>
        </div>
    </div>
</div>
