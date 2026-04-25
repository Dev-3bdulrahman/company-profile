@include('errors.layout', [
    'code'    => '403',
    'title'   => __('Access Forbidden'),
    'message' => __('You do not have permission to access this page.'),
])
