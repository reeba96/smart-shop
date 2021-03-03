<div class="footer">
    <div class="footer-content">

        <div class="newsletter-subscription" style="background-color: #f5f5f5 !important;"> 
            <div class="newsletter-wrapper row col-12">
                <div class="subscribe-newsletter col-lg-4" style="text-align: left !important;">
                    <span style="font-size: 12px; color: black;">
                    Nastojimo da budemo što precizniji u opisu proizvoda, prikazu slika i samih cena, ali ne možemo garantovati da su sve informacije kompletne i bez grešaka. Svi artikli prikazani na sajtu su deo naše ponude i ne podrazumeva da su dostupni u svakom trenutku.
                    </span>
                </div>
            
                <div class="subscribe-newsletter col-lg-8">
                    <img src="/themes/bodywave/assets/images/AmericanExpress50.jpg" class="p-1" alt="American Express">
                    <img src="/themes/bodywave/assets/images/diners_50.gif" class="p-1" alt="Diners Club International">
                    <img src="/themes/bodywave/assets/images/Visa50.gif" class="p-1" alt="Visa">
                    <img src="/themes/bodywave/assets/images/MasterCard50.gif" class="p-1" alt="MasterCard">
                    <img src="/themes/bodywave/assets/images/maestro50.gif" class="p-1" alt="Maestro">
                    <img src="/themes/bodywave/assets/images/discover_50.gif" class="p-1" alt="Discover">
                    <img src="/themes/bodywave/assets/images/dinacard50.png" class="p-1" alt="DinaCard">
                    <img src="/themes/bodywave/assets/images/mastercard-identity-check.png" class="p-1" alt="MasterCard Indentity Check">
                    <img src="/themes/bodywave/assets/images/visa-secure.png" class="p-1" alt="Visa Secure">
                </div>
            </div>
        </div>

        @include('shop::layouts.footer.newsletter-subscription')
        @include('shop::layouts.footer.footer-links')

        {{-- @if ($categories)
            @include('shop::layouts.footer.top-brands')
        @endif --}}

        @if (core()->getConfigData('general.content.footer.footer_toggle'))
            @include('shop::layouts.footer.copy-right')
        @endif
    </div>
</div>


