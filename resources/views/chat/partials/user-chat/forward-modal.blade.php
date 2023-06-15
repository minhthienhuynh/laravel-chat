<div>
    <!-- forward Modal -->
    <div class="modal fade forwardModal" tabindex="-1" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-header-colored shadow-lg border-top-0"
                 x-data="{ selectedRooms: [] }">
                <div class="modal-header">
                    <h5 class="modal-title text-white font-size-16">Share this Message</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                            @click="selectedRooms = []"
                            wire:click="resetModal"></button>
                </div>
                <div class="modal-body p-4">
                    <div>
                        <div class="replymessage-block mb-2">
                            <h5 class="conversation-name">{{ @$message->user->name ?? '' }}</h5>
                            <p class="mb-0">{!! @$message->contents ?? '' !!}</p>
                        </div>
                        <textarea class="form-control" placeholder="Type your message..." rows="2"
                                  wire:model="content"></textarea>
                    </div>
                    <hr class="my-4">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control bg-light border-0 pe-0" placeholder="Search here.."
                               aria-label="Example text with button addon" aria-describedby="forwardSearchbtn-addon">
                        <button class="btn btn-light" type="button" id="forwardSearchbtn-addon"><i class='bx bx-search align-middle'></i></button>
                    </div>

                    <div class="d-flex align-items-center px-1">
                        <div class="flex-grow-1">
                            <h4 class="mb-0 font-size-11 text-muted text-uppercase">Contacts</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-sm btn-primary">Share All</button>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 150px;" class="mx-n4 px-1"
                         wire:ignore>
                        @foreach($rooms->groupBy('list_title') as $listTitle => $list)
                            <div>
                                <div class="contact-list-title">
                                    {{ $listTitle }}
                                </div>

                                <ul class="list-unstyled contact-list @if($loop->last) mb-0 @endif">
                                    @foreach($list as $room)
                                        <li>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h5 class="font-size-14 m-0">{{ $room->display_name }}</h5>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                            x-data="{ btnName: 'Send' }"
                                                            :class="{ 'disabled': selectedRooms.includes({{ $room->id }}) }"
                                                            @click="
                                                                selectedRooms.push({{ $room->id }});
                                                                btnName = selectedRooms.includes({{ $room->id }}) ? 'Sent' : 'Send'"
                                                            x-text="btnName"
                                                            wire:click="send({{ $room->id }})">Send</button>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- end contact list {{ $listTitle }} -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- forward Modal -->
</div>
