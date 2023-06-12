<div class="toast-container position-absolute top-0 end-0 p-4">
    <div id="statusToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('status') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if (session()->has('status'))
                var toastLiveExample = document.getElementById('statusToast')
                var toast = new bootstrap.Toast(toastLiveExample)

                toast.show()
            @endif
        });
    </script>
@endpush
