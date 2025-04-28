<form action="{{ route('emails.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="email_file" accept=".csv,.xlsx,.xls" required>
    <button type="submit">Upload Emails</button>
</form>
