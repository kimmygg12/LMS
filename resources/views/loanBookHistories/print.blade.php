<!DOCTYPE html>
<html>

<head>
    <title>Loan Book History Details</title>
    <style>
        .container {
            width: 80%;
            margin: auto;
        }

        .card {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Loan Book History Details</h1>
        <div class="card">
            <h2>លេខ​វិ​ក័​យ​ប័ត្រ: {{ $loanHistory->invoice_number }}</h2>
            <p>ចំណងជើង: {{ $loanHistory->book->title }}</p>
            <p>ឈ្មោះ: {{ $loanHistory->member->name }}</p>
            <p>តម្លៃ: {{ $loanHistory->price }}</p>
            <p>ថ្ងៃខ្ចី: {{ $loanHistory->loan_date }}</p>
            <p>កំណត់សងថ្ងៃ: {{ $loanHistory->due_date ?? 'N/A' }}</p>
            <p>ខ្ចីបន្តដល់ថ្ងៃ: {{ $loanHistory->renew_date ?? 'N/A' }}</p>
            <p>ផាក់ពិន័យ: {{ $loanHistory->fine ?? 'N/A' }}</p>
            <p>មូលហេតុ: {{ $loanHistory->fine_reason ?? 'N/A' }}</p>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
