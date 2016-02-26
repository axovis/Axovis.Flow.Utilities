=====================
Axovis.Flow.Utilities
=====================

Utility Package for Flow development.

Services
--------
**EmailService** - Based on TYPO3 Swift Mailer to send template/translation based emails

**DateTimeService** - Parse strings to DateTime or create strings from DateTime based on locale

Validators
----------
**ColorStringValidator** - Validates color strings (#000000, rgb(0,0,0), rgba(0,0,0,0))

**DateStringValidator** - Validates dates (accepts multiple formats (01/01/1960, 01.01.1960, ...))

**TimeStringValidator** - Validates times (accepts multiple formats  (01:00 PM, 13:00, ...)) 

**EmailAddressValidator** - extends flows EmailAddressValidator, can check in database for account identifier

**PasswordValidator** - Validates passwords (pass password as array(0 => 'password', 1 => 'password confirmation'))

ViewHelpers
-----------
**RenderExternalViewHelper** - render partials from another package

**PrintDateViewHelper** - prints given date using DateTimeService

**ContextViewHelper** - returns current Flow Context

**RegexViewHelper** - match/replace strings using regex pattern

**InArrayViewHelper** - equivalent to phps's in_array()

**ArrayKeysViewHelper** - equivalent to phps's array_keys()

**IsArrayViewHelper** - equivalent to phps's is_array()

**JsonDecodeViewHelper** - equivalent to phps's json_decode()
