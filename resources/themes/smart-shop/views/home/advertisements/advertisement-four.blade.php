@php
    $isRendered = false;
    $advertisementFour = null;
@endphp

@if ($velocityMetaData && $velocityMetaData->advertisement)
    @php
        $advertisement = json_decode($velocityMetaData->advertisement, true);
        
        if (isset($advertisement[4]) && is_array($advertisement[4])) {
            $advertisementFour = array_values(array_filter($advertisement[4]));
        }
    @endphp

    @if ($advertisementFour)
        @php
            $isRendered = true;
        @endphp

        <div class="container-fluid advertisement-four-container">
            <div class="row">
                
                <div class="col-lg-4">
                    @if ( isset($advertisementFour[0]))
                    <a @if (isset($one)) href="{{ $one }}" @endif>
                        <a href="http://new.quickshop.rs/laptopovi-i-oprema">
                            <img class="img-fluid" src="{{ asset('/storage/' . $advertisementFour[0]) }}" />
                        </a>
                    </a>
                @endif
                </div>

                <div class="col-lg-4">
                    @if ( isset($advertisementFour[1]))
                        <a @if (isset($two)) href="{{ $two }}" @endif>
                            <a href="http://new.quickshop.rs/laptopovi-i-oprema">
                                <img class="img-fluid" src="{{ asset('/storage/' . $advertisementFour[1]) }}" />
                            </a>
                        </a>
                    @endif
                </div>

                <div class="col-lg-4">
                    @if ( isset($advertisementFour[2]))
                            <a @if (isset($three)) href="{{ $three }}" @endif>
                                <a href="http://new.quickshop.rs/laptopovi-i-oprema">
                                    <img class="img-fluid" src="{{ asset('/storage/' . $advertisementFour[2]) }}" />
                                </a>
                            </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endif

@if (! $isRendered)
    <div class="container-fluid advertisement-four-container">
        <div class="row">
            <div class="col-lg-4 col-12 offers-ct-panel">
                <a @if (isset($one)) href="{{ $one }}" @endif>
                    <img class="col-12" src="{{ asset('/themes/velocity/assets/images/big-sale-banner.png') }}" />
                </a>
            </div>

            <div class="col-lg-4 col-12 offers-ct-panel">
                <a @if (isset($two)) href="{{ $two }}" @endif>
                    <img class="col-12" src="{{ asset('/themes/velocity/assets/images/seasons.png') }}" />
                </a>
            </div>

            <div class="col-lg-4 col-12 offers-ct-panel">
                <a @if (isset($three)) href="{{ $three }}" @endif>
                    <img class="col-12" src="{{ asset('/themes/velocity/assets/images/deals.png') }}" />
                </a>
            </div>
            
        </div>
    </div>
@endif