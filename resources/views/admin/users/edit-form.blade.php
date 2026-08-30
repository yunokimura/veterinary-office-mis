@include('admin.users._modal-form', [
    'user' => $user,
    'formAction' => route('admin.users.update', $user),
    'formId' => 'editUserForm',
    'assignableRoles' => $assignableRoles,
    'facilities' => $facilities,
])