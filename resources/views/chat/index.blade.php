@section('title', 'Chat')

@push('styles')
    <link rel="manifest" href="{{ asset('assets/manifest.json') }}" />

    <!-- glightbox css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/glightbox/css/glightbox.min.css') }}">

    <!-- swiper css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">

    <!-- Styles -->
    @livewireStyles
@endpush

@push('scripts')
    <!-- glightbox js -->
    <script src="{{ asset('assets/libs/glightbox/js/glightbox.min.js') }}"></script>

    <!-- Swiper JS -->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- fg-emoji-picker JS -->
    <script src="{{ asset('assets/libs/fg-emoji-picker/fgEmojiPicker.js') }}"></script>

    <!-- page init -->
    <script src="{{ asset('assets/js/pages/index.init.js') }}"></script>

    <!-- Scripts -->
    @vite('resources/js/app.js')

    @livewireScripts
@endpush

<x-chat-layout>
    <div class="layout-wrapper d-lg-flex"
         x-data="{
            onlineUsers: [],
            contactSelected: 0,
            showUserChat: false,
            bgColor: '{{ auth()->user()::$themes['color-classes'][auth()->user()->options['bg-color']]['color'] }}',
            bgImage: 'bg-pattern-{{ auth()->user()->options['bg-image'] }}',
            joinChat: function(room) {
                Echo.join(`chat.${room}`)
                    .here((users) => {
                        const userIds = users.map(user => user.id);
                        this.onlineUsers = [...new Set(this.onlineUsers.concat(userIds))];
                    })
                    .joining((user) => {
                        this.onlineUsers.push(user.id);
                        this.onlineUsers = [...new Set(this.onlineUsers)];
                    })
                    .leaving((user) => {
                        this.onlineUsers = this.onlineUsers.filter(id => id !== user.id);
                    })
                    .listen('NewMessageTyping', (e) => {
                        Livewire.emitTo('user-chat.conversation', 'messageTyping', e.room_id, e.user_id);
                    })
                    .listen('NewMessage', (e) => {
                        Livewire.emit('messageReceived', e.id, e.room_id);
                    })
                    .error((error) => {
                        console.error(error);
                    });
                }
         }"
         :style="bgColor != '' && { '--bs-primary-rgb': bgColor }">

        <!-- Start left sidebar-menu -->
        @livewire('sidebar-menu')
        <!-- end left sidebar-menu -->

        <!-- start chat-leftsidebar -->
        <div class="chat-leftsidebar">

            <div class="tab-content">
                <!-- Start Profile tab-pane -->
                <div class="tab-pane" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                    @livewire('left-sidebar.tabpane-profile')
                </div>
                <!-- End Profile tab-pane -->

                <!-- Start chats tab-pane -->
                <div class="tab-pane show active" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
                    @livewire('left-sidebar.tabpane-chats')
                </div>
                <!-- End chats tab-pane -->

                <!-- Start contacts tab-pane -->
                <div class="tab-pane" id="pills-contacts" role="tabpanel" aria-labelledby="pills-contacts-tab">
                    @livewire('left-sidebar.tabpane-contacts')
                </div>
                <!-- End contacts tab-pane -->

                <!-- Start calls tab-pane -->
                <div class="tab-pane" id="pills-calls" role="tabpanel" aria-labelledby="pills-calls-tab">
                    @livewire('left-sidebar.tabpane-calls')
                </div>
                <!-- End calls tab-pane -->

                <!-- Start bookmark tab-pane -->
                <div class="tab-pane" id="pills-bookmark" role="tabpanel" aria-labelledby="pills-bookmark-tab">
                    @livewire('left-sidebar.tabpane-bookmark')
                </div>
                <!-- End bookmark tab-pane -->

                <!-- Start settings tab-pane -->
                <div class="tab-pane" id="pills-setting" role="tabpanel" aria-labelledby="pills-setting-tab">
                    @livewire('left-sidebar.tabpane-settings')
                </div>
                <!-- End settings tab-pane -->
            </div>
            <!-- end tab content -->
        </div>
        <!-- end chat-leftsidebar -->

        <!-- Start User chat -->
        <div class="user-chat w-100 overflow-hidden"
             :class="{ 'user-chat-show': showUserChat, [bgImage]: true }">
            <div class="user-chat-overlay"
                 :style="bgColor != '' && { background: `rgb(${bgColor})` }"></div>

            @livewire('user-chat.chat-content')
            <!-- end user chat content -->
        </div>
        <!-- End User chat -->

        @stack('modals')
        @include('chat.partials.modals')
        <!-- <video id="video" autoplay="true">

        </video>     -->
    </div>
    <!-- end  layout wrapper -->
</x-chat-layout>
