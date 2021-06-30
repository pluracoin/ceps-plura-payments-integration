# ceps-plura-payments-integration
Tutorial on how to integrate PLURA e-commerce payment system (CEPS)

#### 1. Get your wallet
Download any of these wallets (they're all compatible) and create a new wallet/address. Note
    your mnemonic seed.
To register your store or website on this portal you need your **public wallet address**
    like `Pv7gU9dRVKFg8y1Y3YBLzQJm3owZwhfr8aTS3JaZsJBPa6sZzzDeSE8SHiKsta4MYQWpEg8ok27ufUmoaSKu9L5c2WAgwj5G9`
    and **private view key** like `8720d8bb3ec5c59a40915ec02f92f543542a84e72b48f0f783eed4b1c1223004`.
Wallet address is shown automatically when a wallet is launched. Private view key can be
    shown e.g. in desktop (GUI) wallet in menu Wallet > Export private key > copy View Secret Key.

#### 2. Register your store / website

Create a free account on CEPS Merchant portal (only valid email and password required).

https://merchant.pluracoin.org/register

Then continue with adding your website here https://merchant.pluracoin.org/newstore or click on **Add a new store** link in 
the portal left menu.

To register your store or website the required fields are
* **Store name / URL (identificator)** - A unique name or URL of your store for better
        identification in transaction list or overviews. Each store has to have its unique name.

* **Your wallet address** - A wallet address you've created in previous step.

* **Your wallet private VIEW key** - A private view key you've copied in previous step.
        *Note: Submitting a view key here is absolutely safe and secure for you - nobody can spend
        your money with this key - it's a view key not spend key and is used to recognize your transactions
            in the blockchain only.*
* **Store API key** - An automatically generated token used in communication with your website.
        If you are going to use some of our e-commerce plugin then this key is used automatically.
        If you are going to integrate PLURA payments by yourself then consider this token as an
        additional security option - all calls from Merchant portal will contain this token so you can
        use is as an authorization method. See below.
        
* **After how many confirmations to report the transaction as paid** - the default number of confirmations is set 5. This 
means after how many upcoming blocks to wait until the transaction is considered as valid and is reported by Merchant portal
to your website. 

* **Payment notification URL** - this is the URL where all the calls from Merchant portal will go to. When we find out you
have an incoming transactions we'll check/wait until the required number of confirmations is met. When the number of
confirmations is equal or above the defined treshold (e.g. 5) then we'll call this URL to notify your website about incoming 
payment.

#### 3. Define payment notification URL

If you are going to use some of our e-commerce plugins like payment gateway for VirtueMart, Prestashop then this URL will 
be given to you by the plugin. Just simply copy/paste there the *Callback URL* from plugin. 

If you have a custom system and you prefer your own integration then create some publicly accessible (but hidden) file/URL
 on your webserver. E.g.
 `https://www.mystore123.com/4eb1e037c6493524ff5946f0410fd1cb/plura_payment_notify.php`

Do not publish this address anywhere except the PLURA Merchant portal! 
 
With a "secure" address like this you can be pretty sure nobody will try to mess with your payments confirmations.

So when the required number of confirmations is met we'll call your URL with the predefined variables 
  
`https://www.mystore123.com/4eb1e037c6493524ff5946f0410fd1cb/plura_payment_notify.php?transaction_id=#PLURA_TRANSACTION_ID#&payment_id=#PLURA_PAYMENT_ID#&amount=#PLURA_AMOUNT_DECIMAL#&confirmations=#PLURA_TRANSACTION_CONFIRMATIONS#&api_key=#PLURA_API_KEY#`

**Available variables**
* `#PLURA_TRANSACTION_ID#` - this variable will be replaced with the actual transaction id which is getting confirmed 
(is reported as paid). Example: `76779afd09e3b5435f54b570df138b2efabe2b790b988496b4c84ea0f5c69303`

* `#PLURA_PAYMENT_ID#` - replaced with the Payment ID you have created during the payment details for your customer/order. 
This identifies your exact payment/order. Example: `8d3c07377fdc6d6857fc01d6b04e6b1314f727dd5ed9fd109dae8d060f8c6c99`

* `#PLURA_AMOUNT_DECIMAL#` - replaced with paid amount in a decimal format. You have to check if the paid amount matches the requested amount. Example: `123.45`

* `#PLURA_TRANSACTION_CONFIRMATIONS#` - the number of confirmations the transaction currently has. Example: `5`

 * `#PLURA_API_KEY#` - the `Store API key` defined when you've registered the store. You should check against this 
 variable in your script if it matches = to check if the call isn't forged. Example: 
 `gvq46imIzG8Y1WNP1mFjUSfk8wjJVrtmpdYUlhJYwmyKL9EPA2soZK98fKpxFjbRUcGQIikPhxi6yAawYFDdjWaCli2F6YSGKKhFFcmAUPBaU38kHw30ApZAY1sGnarf`

**Full sample URL**

`https://www.mystore123.com/4eb1e037c6493524ff5946f0410fd1cb/plura_payment_notify.php?transaction_id=76779afd09e3b5435f54b570df138b2efabe2b790b988496b4c84ea0f5c69303
&payment_id=8d3c07377fdc6d6857fc01d6b04e6b1314f727dd5ed9fd109dae8d060f8c6c99
&amount=123.45
&confirmations=5
&api_key=gvq46imIzG8Y1WNP1mFjUSfk8wjJVrtmpdYUlhJYwmyKL9EPA2soZK98fKpxFjbRUcGQIikPhxi6yAawYFDdjWaCli2F6YSGKKhFFcmAUPBaU38kHw30ApZAY1sGnarf`


#### 4. Define HTTP response code
This is required only in case o custom integration. E-commerce plugins users can safely ignore this.

#############

In case you are managing callbacks from CEPS Merchant Portal by yourself you have to provide us with the correct HTTP status 
response code.

`HTTP 200 OK` is understood as the call was successful and the transaction data were successfully processed on your side.

Any other status code is understood as an error. The CEPS Merchant portal will try to notify your URL several times again 
with some delay.

#### 5. Integrate a PLURA payment method into your website 

Every payment request on your website will consist of

* your wallet address
* a unique payment id that identifies current order / transaction
* an amount to be paid in atomic units - example you want a customer to pay 1499 PLURA. PluraCoin has 10 decimal places. An atomic value of 1499 PLURA is 14990000000000 (1499 + 10 decimal places).
* payment decription - optional, url encoded, can contains spaces (useful for mobile wallets so user easily recognizes what he's paying for)

Then compose the payment request like this example

`pluracoin://Pv7gU9dRVKFg8y1Y3YBLzQJm3owZwhfr8aTS3JaZsJBPa6sZzzDeSE8SHiKsta4MYQWpEg8ok27ufUmoaSKu9L5c2WAgwj5G9?amount=14990000000000&name=Sample%20payment&paymentid=f13adc8ac78eb22ffcee3f82e0e9ffb251dc7dc0600ef599087a89b623ca1402`

and make it a clickable link (it opens the GUI or mobile wallet) or encode this string to QR code.

When the customer pays based on these informations your system will be notified via payment notification URL (see chapter 3).