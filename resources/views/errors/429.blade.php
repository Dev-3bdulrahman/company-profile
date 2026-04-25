@include('errors.layout', [
    'code'    => '429',
    'title'   => __('Too Many Requests'),
    'message' => __('You have sent too many requests. Please wait a moment and try again.'),
])
