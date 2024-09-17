# SmartBill PHP SDK

This library is a helper library to consume SmartBill REST API.

Currently it covers only the following API actions:
- Create new invoice
- Create new quote
- Convert quote to invoice
- Create new payment
- Download invoice PDF
- Download quote PDF
- Check invoice state
- Check quote state


# Installation

`composer require stev/smart-bill-php-sdk`

# Usage
Check the samples folder.

If you will use it in a Symfony app, then you only need Stev\SmartBillClient\SmartBillAPI which should be automatically registered by Symfony as a service. Otherwise you need to register it manually. 
