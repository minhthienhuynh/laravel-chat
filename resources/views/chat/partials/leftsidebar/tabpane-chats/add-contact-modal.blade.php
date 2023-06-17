<div>
    <!-- contactModal -->
    <div class="modal fade contactModal" tabindex="-1" aria-hidden="true"
         wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-header-colored shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white font-size-16">Contacts</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <div class="input-group mb-4">
                        <input type="text" class="form-control bg-light border-0 pe-0" placeholder="Search here.." id="searchContactModal" onkeyup="searchContactOnModal()"
                               aria-label="Example text with button addon" aria-describedby="contactSearchbtn-addon">
                        <button class="btn btn-light" type="button" id="contactSearchbtn-addon"><i class='bx bx-search align-middle'></i></button>
                    </div>

                    <div class="d-flex align-items-center px-1">
                        <div class="flex-grow-1">
                            <h4 class=" font-size-11 text-muted text-uppercase">Contacts</h4>
                        </div>
                    </div>
                    <div class="contact-modal-list mx-n4 px-1 overflow-auto" style="max-height: 200px;">
                        @foreach($users->groupBy('upper_left_name_1') as $key => $users)
                            <div class="mt-3">
                                <div class="contact-list-title">
                                    {{ $key }}
                                </div>

                                <ul class="list-unstyled contact-list">
                                    @foreach($users as $user)
                                        <li wire:click="selectUser({{ $user->id }})">
                                            <div>
                                                <h5 class="font-size-14 m-0">{{ $user->name }}</h5>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- end contact list {{ $key }} -->
                        @endforeach
                    </div>
                </div>
                {{--
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary"><i class="bx bxs-send align-middle"></i></button>
                </div>
                --}}
            </div>
        </div>
    </div>
    <!-- contactModal -->
</div>

@push('scripts')
    <script>
        function searchContactOnModal() {
            input = document.getElementById("searchContactModal");
            filter = input.value.toUpperCase();
            list = document.querySelector(".contact-modal-list");
            li = list.querySelectorAll(".mt-3 li");
            div = list.querySelectorAll(".mt-3 .contact-list-title");

            for (j = 0; j < div.length; j++) {
                var contactTitle = div[j];
                txtValue = contactTitle.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    div[j].style.display = "";
                } else {
                    div[j].style.display = "none";
                }
            }

            for (i = 0; i < li.length; i++) {
                contactName = li[i];
                txtValue = contactName.querySelector("h5").innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
@endpush
