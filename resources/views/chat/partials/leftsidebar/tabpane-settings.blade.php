<div>
    <!-- Start Settings content -->
    <div>
        <div class="user-profile-img">
            <img src="{{ asset('assets/images/small/img-4.jpg') }}" class="profile-img profile-foreground-img" style="height: 160px;" alt="">
            <div class="overlay-content">
                <div>
                    <div class="user-chat-nav p-3">

                        <div class="d-flex w-100 align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="text-white mb-0">Settings</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Change Background">
                                    <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input" >
                                    <label for="profile-foreground-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="bx bxs-pencil"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center p-3 p-lg-4 border-bottom pt-2 pt-lg-2 mt-n5 position-relative">
            <div class="mb-3 profile-user">
                <img src="{{ auth()->user()->profile_photo_url }}" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" >
                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                        <span class="avatar-title rounded-circle bg-light text-body">
                            <i class="bx bxs-camera"></i>
                        </span>
                    </label>
                </div>
            </div>

            <h5 class="font-size-16 mb-1 text-truncate"></h5>

            <div class="dropdown d-inline-block">
                <a class="text-muted dropdown-toggle d-block" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bxs-circle {{ $statuses[auth()->user()->status]['class'] }} font-size-10 align-middle"></i> {{ $statuses[auth()->user()->status]['name'] }} <i class="mdi mdi-chevron-down"></i>
                </a>

                <div class="dropdown-menu">
                    @foreach($statuses as $key => $status)
                        <a class="dropdown-item" href="#"
                           wire:click="setUserStatus({{ $key }})"><i class="bx bxs-circle {{ $status['class'] }} font-size-10 me-1 align-middle"></i> {{ $status['name'] }}</a>
                    @endforeach
                </div>
            </div>


        </div>
        <!-- End profile user -->

        <!-- Start User profile description -->
        <div class="user-setting" data-simplebar>
            <div id="settingprofile" class="accordion accordion-flush">
                <div class="accordion-item">
                    <div class="accordion-header" id="headerpersonalinfo">
                        <button class="accordion-button font-size-14 fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#personalinfo" aria-expanded="true" aria-controls="personalinfo"
                                :class="{ collapsed: '{{ $accordionSelected }}' != 'personalinfo' }">
                            <i class="bx bxs-user text-muted me-3"></i> Personal Info
                        </button>
                    </div>
                    <div id="personalinfo" class="accordion-collapse collapse" aria-labelledby="headerpersonalinfo" data-bs-parent="#settingprofile"
                         :class="{ show: '{{ $accordionSelected }}' == 'personalinfo' }">
                        <div class="accordion-body">
                            <div class="float-end">
                                <button type="button" class="btn btn-soft-primary btn-sm"><i class="bx bxs-pencil align-middle"></i></button>
                            </div>

                            <div>
                                <p class="text-muted mb-1">Name</p>
                                <h5 class="font-size-14">{{ auth()->user()->name }}</h5>
                            </div>

                            <div class="mt-4">
                                <p class="text-muted mb-1">Email</p>
                                <h5 class="font-size-14">{{ auth()->user()->email }}</h5>
                            </div>

                            <div class="mt-4">
                                <p class="text-muted mb-1">Location</p>
                                <h5 class="font-size-14 mb-0">California, USA</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end personal info card -->

                <div class="accordion-item">
                    <div class="accordion-header" id="headerthemes">
                        <button class="accordion-button font-size-14 fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethemes" aria-expanded="false" aria-controls="collapsethemes"
                                :class="{ collapsed: '{{ $accordionSelected }}' != 'collapsethemes' }">
                            <i class="bx bxs-adjust-alt text-muted me-3"></i> Themes
                        </button>
                    </div>
                    <div id="collapsethemes" class="accordion-collapse collapse" aria-labelledby="headerthemes" data-bs-parent="#settingprofile"
                         :class="{ show: '{{ $accordionSelected }}' == 'collapsethemes' }">
                        <div class="accordion-body">
                            <div>
                                <h5 class="mb-3 font-size-11 text-muted text-uppercase">Choose Theme Color :</h5>
                                <div class="d-flex align-items-center flex-wrap gap-2 theme-btn-list theme-color-list">
                                    @foreach(\App\Models\User::$themes['color-classes'] as $key => $colorClass)
                                        <div class="form-check">
                                            <input class="form-check-input theme-color" type="radio" value="{{ $key }}" name="bgcolor-radio" id="bgcolor-radio{{ $key }}"
                                                   wire:model.defer="options.bg-color">
                                            <label class="form-check-label avatar-xs" for="bgcolor-radio{{ $key }}"
                                                   wire:click="setTheme"
                                                   @click="bgColor = '{{ $colorClass['color'] }}'">
                                                <span class="avatar-title {{ $colorClass['class'] }} rounded-circle theme-btn bgcolor-radio{{ $key }}"></span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-4 pt-2">
                                <h5 class="mb-3 font-size-11 text-muted text-uppercase">Choose Theme Image :</h5>
                                <div class="d-flex align-items-center flex-wrap gap-2 theme-btn-list theme-btn-list-img">
                                    @foreach(\App\Models\User::$themes['images'] as $key => $image)
                                        <div class="form-check">
                                            <input class="form-check-input theme-img" type="radio" value="{{ $key }}" name="bgimg-radio" id="bgimg-radio{{ $key }}"
                                                   wire:model.defer="options.bg-image">
                                            <label class="form-check-label avatar-xs" for="bgimg-radio{{ $key }}"
                                                   style="background-image: url('{{ asset("$image") }}')"
                                                   wire:click="setTheme"
                                                   @click="bgImage = 'bg-pattern-{{ $key }}'">
                                                <span class="avatar-title bg-pattern-{{ $key }} rounded-circle theme-btn bgimg-radio{{ $key }}"></span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header" id="privacy1">
                        <button class="accordion-button font-size-14 fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#privacy" aria-expanded="false" aria-controls="privacy"
                                :class="{ collapsed: '{{ $accordionSelected }}' != 'privacy' }">
                            <i class="bx bxs-lock text-muted me-3"></i>Privacy
                        </button>
                    </div>
                    <div id="privacy" class="accordion-collapse collapse" aria-labelledby="privacy1" data-bs-parent="#settingprofile"
                         :class="{ show: '{{ $accordionSelected }}' == 'privacy' }">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item py-3 px-0 pt-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-13 mb-0 text-truncate">Profile photo</h5>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <select class="form-select form-select-sm">
                                                <option value="Everyone" selected>Everyone</option>
                                                <option value="Selected">Selected</option>
                                                <option value="Nobody">Nobody</option>
                                            </select>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3 px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-13 mb-0 text-truncate">Last seen</h5>

                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="privacy-lastseenSwitch" checked>
                                                <label class="form-check-label" for="privacy-lastseenSwitch"></label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3 px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-13 mb-0 text-truncate">Status</h5>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <select class="form-select form-select-sm">
                                                <option value="Everyone" selected>Everyone</option>
                                                <option value="Selected">Selected</option>
                                                <option value="Nobody">Nobody</option>
                                            </select>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3 px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-13 mb-0 text-truncate">Read receipts</h5>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="privacy-readreceiptSwitch" checked>
                                                <label class="form-check-label" for="privacy-readreceiptSwitch"></label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3 px-0 pb-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-13 mb-0 text-truncate">Groups</h5>

                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <select class="form-select form-select-sm">
                                                <option value="Everyone" selected>Everyone</option>
                                                <option value="Selected">Selected</option>
                                                <option value="Nobody">Nobody</option>
                                            </select>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end privacy card -->

                <div class="accordion-item">
                    <div class="accordion-header" id="headersecurity">
                        <button class="accordion-button font-size-14 fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesecurity" aria-expanded="false" aria-controls="collapsesecurity"
                                :class="{ collapsed: '{{ $accordionSelected }}' != 'collapsesecurity' }">
                            <i class="bx bxs-check-shield text-muted me-3"></i> Security
                        </button>
                    </div>
                    <div id="collapsesecurity" class="accordion-collapse collapse" aria-labelledby="headersecurity" data-bs-parent="#settingprofile"
                         :class="{ show: '{{ $accordionSelected }}' == 'collapsesecurity' }">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item p-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-13 mb-0 text-truncate">Show security notification</h5>

                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="security-notificationswitch">
                                                <label class="form-check-label" for="security-notificationswitch"></label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end security card -->



                <div class="accordion-item">
                    <div class="accordion-header" id="headerhelp">
                        <button class="accordion-button font-size-14 fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapsehelp" aria-expanded="false" aria-controls="collapsehelp"
                                :class="{ collapsed: '{{ $accordionSelected }}' != 'collapsehelp' }">
                            <i class="bx bxs-help-circle text-muted me-3"></i> Help
                        </button>
                    </div>
                    <div id="collapsehelp" class="accordion-collapse collapse" aria-labelledby="headerhelp" data-bs-parent="#settingprofile"
                         :class="{ show: '{{ $accordionSelected }}' == 'collapsehelp' }">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item py-3 px-0 pt-0">
                                    <h5 class="font-size-13 mb-0"><a href="#" class="text-body d-block">FAQs</a></h5>
                                </li>
                                <li class="list-group-item py-3 px-0">
                                    <h5 class="font-size-13 mb-0"><a href="#" class="text-body d-block">Contact</a></h5>
                                </li>
                                <li class="list-group-item py-3 px-0 pb-0">
                                    <h5 class="font-size-13 mb-0"><a href="#" class="text-body d-block">Terms & Privacy policy</a></h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end profile-setting-accordion -->
        </div>
        <!-- End User profile description -->
    </div>
    <!-- Start Settings content -->
</div>
