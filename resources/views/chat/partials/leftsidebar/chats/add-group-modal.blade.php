<div>
    <!-- Start add group Modal -->
    <div class="modal fade" id="addgroup-exampleModal" tabindex="-1" role="dialog" aria-labelledby="addgroup-exampleModalLabel" aria-hidden="true"
         data-bs-backdrop="static"
         wire:ignore.self
         x-init="
             Livewire.on('groupStored', groupId => {
                addGroupModal.hide();
             })
         ">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modal-header-colored shadow-lg border-0">
                <div class="modal-header">
                    <h5 class="modal-title text-white font-size-16" id="addgroup-exampleModalLabel">Create New Group</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                            wire:click="resetForm">
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-4">
                            <label for="addgroupname-input" class="form-label">Group Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="addgroupname-input" placeholder="Enter Group Name"
                                   wire:model.defer="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Group Members</label>
                            <div class="mb-3">
                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#groupmembercollapse" aria-expanded="false" aria-controls="groupmembercollapse">
                                    Select Members
                                </button>
                            </div>

                            <div class="collapse" id="groupmembercollapse"
                                 wire:ignore>
                                <div class="card border">
                                    <div class="card-header">
                                        <h5 class="font-size-15 mb-0">Contacts</h5>
                                    </div>
                                    <div class="card-body p-2">
                                        <div data-simplebar style="max-height: 150px;">
                                            @foreach($users->groupBy('upper_left_name_1') as $group => $users)
                                                <div>
                                                    <div class="contact-list-title">
                                                        {{ $group }}
                                                    </div>

                                                    <ul class="list-unstyled contact-list">
                                                        @foreach($users as $user)
                                                            <li>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input" id="memberCheck{{ $user->id }}" value="{{ $user->id }}"
                                                                           wire:model.defer="user_ids.{{ $user->id }}">
                                                                    <label class="form-check-label" for="memberCheck{{ $user->id }}">{{ $user->name }}</label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="addgroupdescription-input" class="form-label">Description</label>
                            <textarea class="form-control" id="addgroupdescription-input" rows="3" placeholder="Enter Description"
                                      wire:model.defer="description"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                            wire:click="resetForm">Close</button>
                    <button type="button" class="btn btn-primary"
                            wire:click="store">Create Groups</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End add group Modal -->
</div>
