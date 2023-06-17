<!-- Start chats content -->
<div x-data="{ addGroupModal: new bootstrap.Modal(document.getElementById('addgroup-exampleModal')) }">
    <div class="px-4 pt-4">
        <div class="d-flex align-items-start">
            <div class="flex-grow-1">
                <h4 class="mb-4">Chats</h4>
            </div>
            <div class="flex-shrink-0">
                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Add Contact">

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addContact-exampleModal">
                        <i class="bx bx-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        <form>
            <div class="input-group mb-3">
                <input type="text" class="form-control bg-light border-0 pe-0" id="serachChatUser" onkeyup="searchUser()" placeholder="Search here.."
                aria-label="Example text with button addon" aria-describedby="searchbtn-addon" autocomplete="off">
                <button class="btn btn-light" type="button" id="searchbtn-addon"><i class='bx bx-search align-middle'></i></button>
            </div>
        </form>

    </div> <!-- .p-4 -->

    <div class="chat-room-list overflow-auto">
        <!-- Start chat-message-list -->
        @livewire('left-sidebar.chats.favourites')

        @livewire('left-sidebar.chats.direct-messages')

        @livewire('left-sidebar.chats.channels')
        <!-- End chat-message-list -->
    </div>

    @livewire('left-sidebar.chats.add-group-modal')
</div>
<!-- Start chats content -->

@push('modals')
    @livewire('left-sidebar.chats.add-contact-modal')
@endpush
