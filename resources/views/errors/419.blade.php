@include('errors.layout', [
    'code'    => '419',
    'title'   => __('Session Expired'),
    'message' => __('Your session has expired. Please refresh the page and try again.'),
])
