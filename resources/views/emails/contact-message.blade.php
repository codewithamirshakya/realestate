<x-mail::message>
# New Contact Message

**From:** {{ $inquiry->name }} ({{ $inquiry->email }})

@if($inquiry->phone)
**Phone:** {{ $inquiry->phone }}
@endif

**Message:**

{{ $inquiry->message }}

<x-mail::button :url="config('app.url').'/admin/inquiries'">
View in Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('company.name_en') }} website
</x-mail::message>
