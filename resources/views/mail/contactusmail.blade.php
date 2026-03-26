<x-mail::message>
# New contact form submission

## Name: {{$contactData['name']}}
## Email: {{$contactData['email']}}
## Message: {{$contactData['message']}}

contactData
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
