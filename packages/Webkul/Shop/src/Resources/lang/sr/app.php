<?php

return [
    'invalid_vat_format' => 'PDV id je u pogrešnom formatu.',
    'security-warning' => 'Pronađene su sumnjive aktivnosti!',
    'nothing-to-delete' => 'Nema ništa za brisanje.',

    'layouts' => [
        'my-account' => 'Moj nalog',
        'profile' => 'Profil',
        'address' => 'Adrese',
        'reviews' => 'Recenzije',
        'wishlist' => 'Lista želja',
        'orders' => 'Porudžbine',
        'downloadable-products' => 'Proizvodi za preuzimanje'
    ],

    'common' => [
        'error' => 'Nešto nije u redu, molimo pokušajte ponovo.',
        'no-result-found' => 'Nije moguće pronaći ni jedan zapis.'
    ],

    'home' => [
        'page-title' => config('app.name') . ' - Početna',
        'featured-products' => 'Preporučujemo za Vas',
        'new-products' => 'Novi proizvodi',
        'verify-email' => 'Potvrdite Vašu email adresu.',
        'resend-verify-email' => 'Ponovo pošaljite email za potvrdu.'
    ],

    'header' => [
        'title' => 'Nalog',
        'dropdown-text' => 'Upravljaj korpom, porudžbinama i listom želja',
        'sign-in' => 'Prijavi se',
        'sign-up' => 'Registruj se',
        'account' => 'Nalog',
        'cart' => 'Korpa',
        'profile' => 'Nalog',
        'wishlist' => 'Lista želja',
        'cart' => 'Korpa',
        'logout' => 'Odjavi se',
        'search-text' => 'Pretražite proizvode..'
    ],

    'minicart' => [
        'view-cart' => 'Pregled korpe',
        'checkout' => 'Nastavi dalje',
        'cart' => 'Korpa',
        'zero' => '0'
    ],

    'footer' => [
        'subscribe-newsletter' => 'Pretplata na Newsletter',
        'subscribe' => 'Pretplata',
        'locale' => 'Lokalno',
        'currency' => 'Kanalno',
    ],

    'subscription' => [
        'unsubscribe' => 'Otkaži pretplatu',
        'subscribe' => 'Pretplati se',
        'subscribed' => 'Pretplaćeni ste na email pretplatu.',
        'not-subscribed' => 'Ne možete se pretplatiti na email pretplatu, molimo pokušajte ponovo',
        'already' => 'Već ste pretplaćeni na našu listu pretplanika.',
        'unsubscribed' => 'Otkazali ste pretplatu.',
        'already-unsub' => 'Već ste otkazali pretplatu.',
        'not-subscribed' => 'Greška! Trenutno nije moguće poslati email, molimo pokušajte ponovo.'
    ],

    'search' => [
        'no-results' => 'Nema pronađenih rezultata.',
        'page-title' => config('app.name') . ' - Pretraga',
        'found-results' => 'Pronađeni rezultati pretrage',
        'found-result' => 'Pronađen rezultat pretrage'
    ],

    'reviews' => [
        'title' => 'Naslov',
        'add-review-page-title' => 'Dodaj recenziju',
        'write-review' => 'Napiši recenziju ',
        'review-title' => 'Dodaj naslov',
        'product-review-page-title' => 'Recenzije proizvoda',
        'rating-reviews' => 'Ocena i recenzije',
        'submit' => 'POŠALJI',
        'delete-all' => 'Sve recenzije su uspešno obrisane',
        'ratingreviews' => ':rating Ocene & :review Recenzije',
        'star' => 'Zvezdica',
        'percentage' => ':percentage %',
        'id-star' => 'Zvezdica',
        'name' => 'Ime',
    ],

    'customer' => [
        'signup-text' => [
            'account_exists' => 'Nalog već postoji',
            'title' => 'Prijavi se'
        ],

        'signup-form' => [
            'page-title' => 'Napravi novi nalog',
            'title' => 'Registruj se',
            'firstname' => 'Ime',
            'lastname' => 'Prezime',
            'email' => 'Email',
            'password' => 'Lozinka',
            'confirm_pass' => 'Potvrdi lozinku',
            'button_title' => 'Registruj se',
            'agree' => 'Pristajem',
            'terms' => 'Termini',
            'conditions' => 'Uslovi',
            'using' => 'Koristeći ovaj sajt',
            'agreement' => 'Dogovor',
            'success' => 'Uspešno ste kreirali nalog',
            'success-verify' => 'Uspešno ste kreirali nalog, email za potvrdu je poslat.',
            'success-verify-email-unsent' => 'Uspešno ste kreirali nalog, email za potvrdu nije poslat.',
            'failed' => 'Greška! Nemoguće je kreirati Vaš nalog, molimo pokušajte ponovo.',
            'already-verified' => 'Nalog sa ovom email adresom već postoji, pokušajte da pošaljete novi email za potvrdu!',
            'verification-not-sent' => 'Greška! Problem pri slanju email-a za potvrdu, molimo pokušajte ponovo.',
            'verification-sent' => 'Email za potvrdu je poslat.',
            'verified' => 'Vaš nalog je potvrđen, pokušajte se prijaviti.',
            'verify-failed' => 'Nemoguće je potvrditi Vaš email.',
            'dont-have-account' => 'Nemate kreiran nalog.',
            'customer-registration' => 'Uspešna registracija korisnika!'
        ],

        'login-text' => [
            'no_account' => 'Nemate postojeći nalog',
            'title' => 'Prijavi se',
        ],

        'login-form' => [
            'page-title' => 'Prijava kupca',
            'title' => 'Prijavi se',
            'email' => 'Email',
            'password' => 'Lozinka',
            'forgot_pass' => 'Zaboravili ste lozinku ?',
            'button_title' => 'Prijavi se',
            'remember' => 'Zapamti me',
            'footer' => '© Copyright :year Webkul Software, All rights reserved',
            'invalid-creds' => 'Proverite svoje podatke i molimo pokušajte ponovo',
            'verify-first' => 'Prvo potvrdite Vaš email. ',
            'not-activated' => 'Vaša aktivacija traži odobrenje administratora',
            'resend-verification' => 'Ponovo pošaljite email za potvrdu'
        ],

        'forgot-password' => [
            'title' => 'Resetovanje lozinke',
            'email' => 'Email',
            'submit' => 'Pošaljite email za resetovanje lozinke',
            'page_title' => 'Zaboravili ste lozinku ?'
        ],

        'reset-password' => [
            'title' => 'Resetovanje lozinke',
            'email' => 'Email adresa',
            'password' => 'Lozinka',
            'confirm-password' => 'Potvrdite lozinku',
            'back-link-title' => 'Nazad na Prijavi se',
            'submit-btn-title' => 'Resetuj lozinku'
        ],

        'account' => [
            'dashboard' => 'Uredi nalog',
            'menu' => 'Meni',

            'profile' => [
                'index' => [
                    'page-title' => 'Nalog',
                    'title' => 'Nalog',
                    'edit' => 'Uredi',
                ],

                'edit-success' => 'Uspešno ste ažurirali nalog.',
                'edit-fail' => 'Greška! Profil se ne može ažurirati, molimo pokušajte ponovo.',
                'unmatch' => 'Stara lozinka se ne podudara.',

                'fname' => 'Ime',
                'lname' => 'Prezime',
                'gender' => 'Pol',
                'other' => 'Drugo',
                'male' => 'Muški',
                'female' => 'Ženski',
                'dob' => 'Datum rođenja',
                'phone' => 'Telefon',
                'email' => 'Email',
                'opassword' => 'Stara lozinka',
                'password' => 'Lozinka',
                'cpassword' => 'Potvrdi lozinku',
                'submit' => 'Ažuriraj nalog',

                'edit-profile' => [
                    'title' => 'Uredi nalog',
                    'page-title' => 'Uredi formu naloga'
                ]
            ],

            'address' => [
                'index' => [
                    'page-title' => 'Adresa',
                    'title' => 'Adresa',
                    'add' => 'Dodaj adresu',
                    'edit' => 'Uredi',
                    'empty' => 'Nemate nijednu sačuvanu adresu, otvorite link iznad i pokušajte ponovo.',
                    'create' => 'Kreiraj adresu',
                    'delete' => 'Obriši',
                    'make-default' => 'Postavi podrazumevano',
                    'default' => 'Podrazumevano',
                    'contact' => 'Kontakti',
                    'confirm-delete' =>  'Da li ste sigurni da želite obrisati ovu adresu?',
                    'default-delete' => 'Podrazumevana adresa ne može da se promeni.',
                    'enter-password' => 'Unesite Vašu lozinku.',
                ],

                'create' => [
                    'page-title' => 'Dodaj formu za adresu',
                    'company_name' => 'Naziv kompanije',
                    'first_name' => 'Ime',
                    'last_name' => 'Prezime',
                    'vat_id' => 'Vat id',
                    'vat_help_note' => '[Note: Use Country Code with VAT Id. Eg. INV01234567891]',
                    'title' => 'Dodaj adresu',
                    'street-address' => 'Ulica i broj',
                    'country' => 'Država',
                    'state' => 'Zemlja',
                    'select-state' => 'Izaberite mesto, region i državu',
                    'city' => 'Grad',
                    'postcode' => 'Poštanski broj',
                    'phone' => 'Telefon',
                    'submit' => 'Sačuvaj adresu',
                    'success' => 'Adresa je uspešno dodata.',
                    'error' => 'Adresa ne može biti dodata.'
                ],

                'edit' => [
                    'page-title' => 'Izmeni adresu',
                    'company_name' => 'Naziv kompanije',
                    'first_name' => 'Ime',
                    'last_name' => 'Prezime',
                    'vat_id' => 'Vat id',
                    'title' => 'Uredi adresu',
                    'street-address' => 'Ulica i broj',
                    'submit' => 'Sačuvaj adresu',
                    'success' => 'Adresa je uspešno ažurirana.',
                ],
                'delete' => [
                    'success' => 'Adresa je uspešno obrisana',
                    'failure' => 'Adresa se ne može obrisati',
                    'wrong-password' => 'Pogrešna lozinka!'
                ]
            ],

            'order' => [
                'index' => [
                    'page-title' => 'Porudžbine',
                    'title' => 'Porudžbine',
                    'order_id' => 'ID porudžbine',
                    'date' => 'Datum',
                    'status' => 'Status',
                    'total' => 'Ukupno',
                    'order_number' => 'Broj porudžbine',
                    'processing' => 'Obrada',
                    'completed' => 'Završeno',
                    'canceled' => 'Otkazano',
                    'closed' => 'Zatvoreno',
                    'pending' => 'Nedovršeno',
                    'pending-payment' => 'Plaćanje u toku',
                    'fraud' => 'Prevara'
                ],

                'view' => [
                    'page-tile' => 'Porudžbina #:order_id',
                    'info' => 'Informacija',
                    'placed-on' => 'Postavljeno',
                    'products-ordered' => 'Poručeni proizvodi',
                    'invoices' => 'Fakture',
                    'shipments' => 'Pošiljke',
                    'SKU' => 'SKU',
                    'product-name' => 'Ime',
                    'qty' => 'Količina',
                    'item-status' => 'Status predmeta',
                    'item-ordered' => 'Poručeno (:qty_ordered)',
                    'item-invoice' => 'Fakturisano (:qty_invoiced)',
                    'item-shipped' => 'Poslato (:qty_shipped)',
                    'item-canceled' => 'Otkazano (:qty_canceled)',
                    'item-refunded' => 'Vraćeno (:qty_refunded)',
                    'price' => 'Cena',
                    'total' => 'Ukupno',
                    'subtotal' => 'Međuzbir',
                    'shipping-handling' => 'Isporuka i rukovođenje',
                    'tax' => 'Porez',
                    'discount' => 'Popust',
                    'tax-percent' => 'Procenat popusta',
                    'tax-amount' => 'Iznos poreza',
                    'discount-amount' => 'Iznos popusta',
                    'grand-total' => 'Ukupan iznos',
                    'total-paid' => 'Ukupno plaćeno',
                    'total-refunded' => 'Ukupno vraćeno',
                    'total-due' => 'Ukupan iznos',
                    'shipping-address' => 'Adresa isporuke',
                    'billing-address' => 'Adresa fakturisanja',
                    'shipping-method' => 'Način isporuke',
                    'payment-method' => 'Način plaćanja',
                    'individual-invoice' => 'Faktura #:invoice_id',
                    'individual-shipment' => 'Pošiljka #:shipment_id',
                    'print' => 'Štampaj',
                    'invoice-id' => 'ID fakture',
                    'order-id' => 'ID porudžbine',
                    'order-date' => 'Datum porudžbine',
                    'bill-to' => 'Račun za',
                    'ship-to' => 'Isporuka za',
                    'contact' => 'Kontakt',
                    'refunds' => 'Povrat',
                    'individual-refund' => 'Povrat #:refund_id',
                    'adjustment-refund' => 'Regulisanje povrata',
                    'adjustment-fee' => 'Regulisanje iznosa',
                    'cancel-btn-title' => 'Otkaži',
                ]
            ],

            'wishlist' => [
                'page-title' => 'Lista želja',
                'title' => 'Lista želja',
                'deleteall' => 'Obriši sve',
                'moveall' => 'Premesti sve proizvode u korpu',
                'move-to-cart' => 'Premesti u korpu',
                'error' => 'Proizvod je nemoguće dodati na listu želja, molimo pokušajte ponovo.',
                'add' => 'Stavka je dodata na listu želju',
                'remove' => 'Stavka je uklonjena sa liste želja',
                'moved' => 'Stavka je premeštena u korpu',
                'option-missing' => 'Nemoguće je premestiti stavku na listu želja, nedostaju opcije.',
                'move-error' => 'Nemoguće je prebaciti stavku na listu želja, molimo pokušajte ponovo',
                'success' => 'Uspešno dodata stavka na listu želja',
                'failure' => 'Nemoguće je dodati stavku na listu želja, molimo pokušajte ponovo',
                'already' => 'Stavka je već dodata na listu želja',
                'removed' => 'Stavka je uspešno uklonjena sa liste želja',
                'remove-fail' => 'Nemoguće je ukloniti stavku sa liste želja',
                'empty' => 'Nemate nijednu stavku na listi želja',
                'remove-all-success' => 'Sve stavke iz Vaše liste želja su uklonjene',
            ],

            'downloadable_products' => [
                'title' => 'Proizvodi za preuzimanje',
                'order-id' => 'ID porudžbine',
                'date' => 'Datum',
                'name' => 'Naslov',
                'status' => 'Status',
                'pending' => 'Nedovršen',
                'available' => 'Dostupan',
                'expired' => 'Istekao',
                'remaining-downloads' => 'Preostala preuzimanja',
                'unlimited' => 'Neograničen',
                'download-error' => 'Link za preuzimanje je istekao.'
            ],

            'review' => [
                'index' => [
                    'title' => 'Recenzije',
                    'page-title' => 'Recenzije'
                ],

                'view' => [
                    'page-tile' => 'Komentar #:id',
                ]
            ]
        ]
    ],

    'products' => [
        'layered-nav-title' => 'Filtriranje',
        'price-label' => 'Nisko kao',
        'remove-filter-link-title' => 'Ukloni sve',
        'sort-by' => 'Sortiraj po',
        'from-a-z' => 'Od A-Z',
        'from-z-a' => 'Od Z-A',
        'newest-first' => 'Najnovije prvo',
        'oldest-first' => 'Najstarije prvo',
        'cheapest-first' => 'Najjeftinije prvo',
        'expensive-first' => 'Najskuplje prvo',
        'show' => 'Prikaži',
        'pager-info' => 'Prikaži :showing od :total stavki',
        'description' => 'Opis',
        'specification' => 'Specifikacija',
        'total-reviews' => ':total Recenzije',
        'total-rating' => ':total_rating Ocene & :total_reviews Recenzije',
        'by' => 'Po :name',
        'up-sell-title' => 'Pronašli smo još jedan proizvod koji će Vam se možda svideti !',
        'related-product-title' => 'Slični proizvodi',
        'cross-sell-title' => 'Više izbora',
        'reviews-title' => 'Ocene i recenzije',
        'write-review-btn' => 'Napiši recenziju',
        'choose-option' => 'Odaberi opciju',
        'sale' => 'Rasprodaja',
        'new' => 'Novo',
        'empty' => 'Nema dostupnih proizvoda za odabranu kategoriju',
        'add-to-cart' => 'Dodaj u korpu',
        'buy-now' => 'Kupi odmah',
        'whoops' => 'Oops!',
        'quantity' => 'Količina',
        'in-stock' => 'Na zalihama',
        'out-of-stock' => 'Nema na zalihama',
        'view-all' => 'Pogledaj sve',
        'select-above-options' => 'Prvo odaberite gore navedene opcije.',
        'less-quantity' => 'Količina ne može biti manja od jedan.',
        'samples' => 'Primerci',
        'links' => 'Linkovi',
        'sample' => 'Primer',
        'name' => 'Naziv',
        'qty' => 'Količina',
        'starting-at' => 'Cena od',
        'customize-options' => 'Prilagodi podešavanja',
        'choose-selection' => 'Izaberi selekciju',
        'your-customization' => 'Vaša podešavanja',
        'total-amount' => 'Ukupna količina',
        'none' => 'Nema',
        'available' => 'Dostupno',
        'book-now' => 'Dodaj u korpu'
    ],

    // 'reviews' => [
    //     'empty' => 'You Have Not Reviewed Any Of Product Yet'
    // ]

    'buynow' => [
        'no-options' => 'Molimo Vas izaberite opcije pre kupovine proizvoda.'
    ],

    'checkout' => [
        'cart' => [
            'integrity' => [
                'missing_fields' => 'Niste popunili obavezna polja.',
                'missing_options' => 'Nedostaju opcije za ovaj proizvod.',
                'missing_links' => 'Nedostaje link za preuzimanje ovog proizvoda.',
                'qty_missing' => 'Najmanje jedan proizvod mora imati više od 1 količine.',
                'qty_impossible' => 'Ne možete dodati više od jednog proizvoda u korpu.'
            ],
            'create-error' => 'Naišli smo na problem prilikom kreiranja korpe. ',
            'title' => 'Potrošačka korpa',
            'empty' => 'Potrošačka korpa je prazna.',
            'update-cart' => 'Ažuriraj korpu.',
            'continue-shopping' => 'Nastavite kupovinu',
            'proceed-to-checkout' => 'Nastavite u korpu',
            'remove' => 'Ukloniti',
            'remove-link' => 'Ukloniti',
            'move-to-wishlist' => 'Premestite u listu želja.',
            'move-to-wishlist-success' => 'Stavka je premeštena u listu želja.',
            'move-to-wishlist-error' => 'Nemoguće je premestiti staku u listu želja, molimo pokušajte ponovo.',
            'add-config-warning' => 'Molimo izaberite opciju pre dodavanja u korpu.',
            'quantity' => [
                'quantity' => 'Količina',
                'success' => 'Stavke u korpi su uspešno ažurirane. ',
                'illegal' => 'Količina ne može biti manja od jedan.',
                'inventory_warning' => 'Tražena količina nije dostupna, molimo pokušajte ponovo.',
                'error' => 'Nemoguće je ažurirati stavku, molimo pokušajte ponovo.'
            ],

            'item' => [
                'error_remove' => 'Nema stavki za ukloniti iz korpe.',
                'success' => 'Stavka je uspešno dodata u korpu.',
                'success-remove' => 'Stavka je uspešno uklonjena iz korpe. ',
                'error-add' => 'Nemoguće je dodati stavku u korpu, molimo pokušajte ponovo.',
            ],
            'quantity-error' => 'Tražena količina nije dostupna.',
            'cart-subtotal' => 'Međuzbir korpe',
            'cart-remove-action' => 'Da li ste sigurni?',
            'partial-cart-update' => 'Samo neke od stavki su ažurirane.',
            'link-missing' => '',
            'event' => [
                'expired' => 'Događaj je istekao.'
            ]
        ],

        'onepage' => [
            'title' => 'Nastavi za kupovinu',
            'information' => 'Informacija',
            'shipping' => 'Isporuka',
            'payment' => 'Plaćanje',
            'complete' => 'Dovršeno',
            'billing-address' => 'Adresa za naplatu',
            'sign-in' => 'Prijavite se',
            'company-name' => 'Naziv kompanije',
            'first-name' => 'Ime',
            'last-name' => 'Prezime',
            'email' => 'Email',
            'address1' => 'Ulica i broj',
            'city' => 'Grad',
            'state' => 'Država',
            'select-state' => 'Izaberite mesto, državu ili region',
            'postcode' => 'Poštanski broj',
            'phone' => 'Telefon',
            'country' => 'Država',
            'order-summary' => 'Pregled porudžbine',
            'shipping-address' => 'Adresa isporuke',
            'use_for_shipping' => 'Isporučiti na adresu',
            'continue' => 'Nastavi',
            'shipping-method' => 'Izaberi način slanja',
            'payment-methods' => 'Izaberi način plaćanja',
            'payment-method' => 'Način plaćanja',
            'summary' => 'Pregled porudžbine',
            'price' => 'Cena',
            'quantity' => 'Količina',
            'billing-address' => 'Adresa za naplatu',
            'shipping-address' => 'Adresa isporuke',
            'contact' => 'Kontakt',
            'place-order' => 'Poruči',
            'new-address' => 'Dodajte novu adresu',
            'save_as_address' => 'Sačuvajte adresu',
            'apply-coupon' => 'Iskoristite kupon',
            'amt-payable' => 'Naplativ iznos',
            'got' => 'Uzmi',
            'free' => 'Besplatno',
            'coupon-used' => 'Kupon je iskorišćen',
            'applied' => 'Primenje',
            'back' => 'Nazad',
            'cash-desc' => 'Po pouzeću',
            'money-desc' => 'Transfer novca',
            'paypal-desc' => 'Paypal standardi',
            'free-desc' => 'Besplatna dostava',
            'flat-desc' => 'Paušalno plaćanje',
            'password' => 'Lozinka',
            'login-exist-message' => 'Već imate nalog, prijavite se ili nastavite kao gost.',
            'enter-coupon-code' => 'Unesite kod za kupon.'
        ],

        'total' => [
            'order-summary' => 'Pregled porudžbine',
            'sub-total' => 'Stavke',
            'grand-total' => 'Ukupan iznos',
            'delivery-charges' => 'Troškovi dostave',
            'tax' => 'Porez',
            'discount' => 'Popust',
            'price' => 'Cena',
            'disc-amount' => 'Iznos sniženja',
            'new-grand-total' => 'Novi ukupan iznos',
            'coupon' => 'Kupon',
            'coupon-applied' => 'Primenjen kupon',
            'remove-coupon' => 'Uklonite kupon',
            'cannot-apply-coupon' => 'Nemoguće je upotrebiti',
            'invalid-coupon' => 'Kod za kupon je nevažeći.',
            'success-coupon' => 'Kod za kupon je uspešno upotrebljen.',
            'coupon-apply-issue' => 'Nemoguće je upotrebiti kod.'
        ],

        'success' => [
            'title' => 'Uspešno ste izvršili porudžbinu.',
            'thanks' => 'Hvala Vam na poručivanju!',
            'order-id-info' => 'Vaša porudžbina je #:order_id',
            'info' => 'Detalje o porudžbini i informacije o praćenju ćemo Vam proslediti na email adresu.'
        ]
    ],

    'mail' => [
        'order' => [
            'subject' => 'Potvrda nove porudžbine.',
            'heading' => 'Potvrda porudžbine!',
            'dear' => 'Dragi/a :customer_name',
            'dear-admin' => 'Dragi/a :admin_name',
            'greeting' => 'Hvala na porudžbini :order_id placed on :created_at',
            'greeting-admin' => 'ID porudžbine :order_id placed on :created_at',
            'summary' => 'Pregled porudžbine',
            'shipping-address' => 'Adresa isporuke',
            'billing-address' => 'Adresa za naplatu',
            'contact' => 'Kontakt',
            'shipping' => 'Način isporuke',
            'payment' => 'Način plaćanja',
            'price' => 'Cena',
            'quantity' => 'Količina',
            'subtotal' => 'Međuzbir',
            'shipping-handling' => 'Isporuka i rukovođenje',
            'tax' => 'Porez',
            'discount' => 'Popust',
            'grand-total' => 'Ukupan iznos',
            'final-summary' => 'Hvala Vam na pokazanom interesovanju, nakon isporuke prosledićemo Vam broj za praćenje pošiljke.',
            'help' => 'Ukoliko Vam je potrebna pomoć, kontaktirajte nas na :support_email',
            'thanks' => 'Hvala!',
            'cancel' => [
                'subject' => 'Potvrda o otkazivanju porudžbine',
                'heading' => 'Otkazivanje porudžbine',
                'dear' => 'Dragi/a :customer_name',
                'greeting' => 'Vaša porudžbina sa ID #:order_id poslata :created_at je otkazana',
                'summary' => 'Pregled porudžbine',
                'shipping-address' => 'Adresa isporuke',
                'billing-address' => 'Adresa za naplatu',
                'contact' => 'Kontakt',
                'shipping' => 'Način isporuke',
                'payment' => 'Način plaćanja',
                'subtotal' => 'Međuzbir',
                'shipping-handling' => 'Isporuka i rukovođenje',
                'tax' => 'Porez',
                'discount' => 'Popust',
                'grand-total' => 'Ukupan iznos',
                'final-summary' => 'Hvala Vam na ukazanom interesovanju.',
                'help' => 'Ukoliko Vam je potrebna pomoć, kontaktirajte nas na at :support_email',
                'thanks' => 'Hvala!',
            ]
        ],

        'invoice' => [
            'heading' => 'Vaša faktura #:invoice_id za porudžbinu #:order_id',
            'subject' => 'Faktura za Vašu porudžbinu #:order_id',
            'summary' => 'Pregled fakture',
        ],

        'shipment' => [
            'heading' => 'Pošiljka #:shipment_id  je generisana za porudžbinu Order #:order_id',
            'inventory-heading' => 'Nova pošiljka #:shipment_id je generisana za pošiljku #:order_id',
            'subject' => 'Pošiljka za Vašu porudžbinu #:order_id',
            'inventory-subject' => 'Nova pošiljka je generisana za porudžbinu #:order_id',
            'summary' => 'Pregled pošiljke',
            'carrier' => 'Dostavljač',
            'tracking-number' => 'Broj za praćenje',
            'greeting' => 'Porudžbina :order_id je postavljena na :created_at',
        ],

        'refund' => [
            'heading' => 'Vaš povrat #:refund_id za porudžbinu #:order_id',
            'subject' => 'Povrat za porudžbinu #:order_id',
            'summary' => 'Pregled povrata novca',
            'adjustment-refund' => 'Regulisanje povrata',
            'adjustment-fee' => 'Regulisanaje iznosa'
        ],

        'forget-password' => [
            'subject' => 'Korisničko resetovanje lozinke',
            'dear' => 'Dragi/a :name',
            'info' => 'Dobili ste ovu poruku, jer smo sa Vašeg naloga dobili zahtev za resetovanje lozike.',
            'reset-password' => 'Resetuj lozinku',
            'final-summary' => 'Ukoliko niste zatražili resetovanje lozinke, dalje radnje nisu potebne.',
            'thanks' => 'Hvala!'
        ],

        'customer' => [
            'new' => [
                'dear' => 'Dragi/a :customer_name',
                'username-email' => 'Korisničko ime/Email',
                'subject' => 'Registracija novog kupca',
                'password' => 'Lozinka',
                'summary' => 'Vaš nalog je kreiran.
                Detalji o Vašem nalogu nalaze se ispod: ',
                'thanks' => 'Hvala!',
            ],

            'registration' => [
                'subject' => 'Registracija novog kupca',
                'customer-registration' => 'Registracija uspešno izvršena.',
                'dear' => 'Dragi/a :customer_name',
                'greeting' => 'Dobrodošli i hvala Vam što ste se registrovali!',
                'summary' => 'Vaš nalog je uspešno kreiran, možete se prijaviti koristeći Vaš email i lozinku. Nakon prijavljivanja, možete pristupiti drugim uslugama kao što je pregled prošlih porudžbina, liste želja i uređivanje podataka o Vašem nalogu.                .',
                'thanks' => 'Hvala!',
            ],

            'verification' => [
                'heading' => config('app.name') . ' - Email za potvrdu',
                'subject' => 'Potvrda',
                'verify' => 'Potvrdite Vaš nalog.',
                'summary' => 'Ovo je poruka za potvrdu da je email adresa Vaša.
                Kliknite na dugme dole - Potvrdite Vaš nalog - kako biste potvrdili Vaš nalog.'
            ],

            'subscription' => [
                'subject' => 'Email za pretplatu',
                'greeting' => ' Dobrodošli na ' . config('app.name') . ' - Email za pretplatu.',
                'unsubscribe' => 'Otkažite pretplatu.',
                'summary' => 'Hvala što ste se pretplatili na naš Newsletter. Prošlo je neko vreme otkako ste pročitali ' . config('app.name') . ' email i ne želimo da preopteretimo Vašu poštu. Ukoliko ne želite da primate
                poslednje novosti, pritisnite dugme ispod'
            ]
        ]
    ],

    'webkul' => [
        'copy-right' => '© Copyright :year Webkul Software, All rights reserved',
    ],

    'response' => [
        'create-success' => ':name je uspešno kreirano.',
        'update-success' => ':name je uspešno ažurirano.',
        'delete-success' => ':name je uspešno obrisano.',
        'submit-success' => ':name je uspešno poslato.'
    ],
];
