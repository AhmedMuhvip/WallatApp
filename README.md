# WalletApp

A Laravel-based wallet application for processing and managing bank transactions. This application supports multiple bank integrations with custom transaction parsing and XML-based payment processing.

## Features

- **Multi-Bank Support**: Integrates with multiple banks (AcmeBank, PayTechBank) using a flexible abstract bank class
- **Transaction Processing**: Parse and store transactions from different bank formats

## Requirements

- PHP 8.2+
- Composer
- MySQL

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd WalletApp
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**
   
   Update your `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=wallet_app
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

## Quick Setup

You can also use the composer setup script:
```bash
composer setup
```

This will install dependencies, create `.env`, generate app key, run migrations, and build assets.

## Development

Start the development server with all services:
```bash
composer dev
```

This runs concurrently:
- Laravel development server
- Queue listener
- Log viewer (Pail)
- Vite dev server

## Project Structure

```
app/
├── Bank.php              # Abstract bank class for transaction processing
├── AcmeBank.php          # AcmeBank implementation
├── PayTechBank.php       # PayTechBank implementation
├── Models/
│   ├── Bank.php          # Bank Eloquent model
│   ├── Client.php        # Client Eloquent model
│   ├── Transaction.php   # Transaction Eloquent model
│   └── WebhookIngestion.php  # Webhook data model
├── Http/
│   ├── Controllers/      # Application controllers
│   └── Requests/         # Form request validation
└── Providers/
    └── AppServiceProvider.php
```

## Bank Integration

### Adding a New Bank

1. Create a new class extending `App\Bank`:
   ```php
   <?php

   namespace App;

   class NewBank extends Bank
   {
       public function parse(string $transaction)
       {
           // Parse transaction string and return array
           return [
               'date' => $parsedDate,
               'amount' => $parsedAmount,
               'reference' => $referenceCode,
               'meta_Data' => $additionalData
           ];
       }
   }
   ```

2. Implement the `parse()` method to handle the bank's specific transaction format.

### Transaction Format Examples

**AcmeBank Format:**
```
100,50//REF123//2025-02-15
```

**PayTechBank Format:**
```
20250215010050#REF123/NOTE/value/INTERNAL/code
```

## XML Payment Messages

The application supports XML-based payment request messages:

```xml
<?xml version="1.0" encoding="utf-8"?>
<PaymentRequestMessage>
    <TransferInfo>
        <Reference>e0f4763d-28ea-42d4-ac1c-c4013c242105</Reference>
        <Date>2025-02-25 06:33:00+03</Date>
        <Amount>177.39</Amount>
        <Currency>SAR</Currency>
    </TransferInfo>
    <SenderInfo>
        <AccountNumber>SA6980000204608016212908</AccountNumber>
    </SenderInfo>
    <ReceiverInfo>
        <BankCode>FDCSSARI</BankCode>
        <AccountNumber>SA6980000204608016211111</AccountNumber>
        <BeneficiaryName>Jane Doe</BeneficiaryName>
    </ReceiverInfo>
    <Notes>
        <Note>Lorem Epsum</Note>
        <Note>Dolor Sit Amet</Note>
    </Notes>
    <PaymentType>421</PaymentType>
    <ChargeDetails>RB</ChargeDetails>
</PaymentRequestMessage>
```

## Database Schema

### Banks Table
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Bank name |
| code | string | Bank code |

### Clients Table
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Client name |
| email | string | Client email |
| phone | string | Phone number |
| address | string | Address |

### Transactions Table
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| client_id | bigint | Foreign key to clients |
| bank_id | bigint | Foreign key to banks |
| amount | double | Transaction amount |
| status | string | Transaction status |
| type | string | Transaction type |
| date | datetime | Transaction date |
| description | string | Description |
| reference | string | Unique reference |
| meta_data | json | Additional metadata |

