@include('errors.layout', [
    'code'    => '404',
    'title'   => __('Page Not Found'),
    'message' => __('The page you are looking for does not exist or has been moved.'),
])
