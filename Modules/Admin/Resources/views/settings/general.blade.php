@extends('layouts.admin.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="pheading">
                        <h2><a href="{{ route('admin.settings') }}"><i class="las la-arrow-left"></i></a> General</h2>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-green btn-submit"><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> Save Changes</button>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="g-setting">
                        <form action="{{ route('admin.settings.general') }}" name="form-add" method="" onsubmit="return false;">
                            @csrf
                            <div class="row">
                                <h3>Standard and Formats</h3>
                                <div class="col-md-12">
                                    <?php
                                    $timezones = array(
                                        "Etc/GMT+12" => "(GMT-12:00) International Date Line West",
                                        "Pacific/Midway" => "(GMT-11:00) Midway Island, Samoa",
                                        "Pacific/Honolulu" => "(GMT-10:00) Hawaii",
                                        "US/Alaska" => "(GMT-09:00) Alaska",
                                        "America/Los_Angeles" => "(GMT-08:00) Pacific Time (US & Canada)",
                                        "America/Tijuana" => "(GMT-08:00) Tijuana, Baja California",
                                        "US/Arizona" => "(GMT-07:00) Arizona",
                                        "America/Chihuahua" => "(GMT-07:00) Chihuahua, La Paz, Mazatlan",
                                        "US/Mountain" => "(GMT-07:00) Mountain Time (US & Canada)",
                                        "America/Managua" => "(GMT-06:00) Central America",
                                        "US/Central" => "(GMT-06:00) Central Time (US & Canada)",
                                        "America/Mexico_City" => "(GMT-06:00) Guadalajara, Mexico City, Monterrey",
                                        "Canada/Saskatchewan" => "(GMT-06:00) Saskatchewan",
                                        "America/Bogota" => "(GMT-05:00) Bogota, Lima, Quito, Rio Branco",
                                        "US/Eastern" => "(GMT-05:00) Eastern Time (US & Canada)",
                                        "US/East-Indiana" => "(GMT-05:00) Indiana (East)",
                                        "Canada/Atlantic" => "(GMT-04:00) Atlantic Time (Canada)",
                                        "America/Caracas" => "(GMT-04:00) Caracas, La Paz",
                                        "America/Manaus" => "(GMT-04:00) Manaus",
                                        "America/Santiago" => "(GMT-04:00) Santiago",
                                        "Canada/Newfoundland" => "(GMT-03:30) Newfoundland",
                                        "America/Sao_Paulo" => "(GMT-03:00) Brasilia",
                                        "America/Argentina/Buenos_Aires" => "(GMT-03:00) Buenos Aires, Georgetown",
                                        "America/Godthab" => "(GMT-03:00) Greenland",
                                        "America/Montevideo" => "(GMT-03:00) Montevideo",
                                        "America/Noronha" => "(GMT-02:00) Mid-Atlantic",
                                        "Atlantic/Cape_Verde" => "(GMT-01:00) Cape Verde Is.",
                                        "Atlantic/Azores" => "(GMT-01:00) Azores",
                                        "Africa/Casablanca" => "(GMT+00:00) Casablanca, Monrovia, Reykjavik",
                                        "Etc/Greenwich" => "(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London",
                                        "Europe/Amsterdam" => "(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
                                        "Europe/Belgrade" => "(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
                                        "Europe/Brussels" => "(GMT+01:00) Brussels, Copenhagen, Madrid, Paris",
                                        "Europe/Sarajevo" => "(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb",
                                        "Africa/Lagos" => "(GMT+01:00) West Central Africa",
                                        "Asia/Amman" => "(GMT+02:00) Amman",
                                        "Europe/Athens" => "(GMT+02:00) Athens, Bucharest, Istanbul",
                                        "Asia/Beirut" => "(GMT+02:00) Beirut",
                                        "Africa/Cairo" => "(GMT+02:00) Cairo",
                                        "Africa/Harare" => "(GMT+02:00) Harare, Pretoria",
                                        "Europe/Helsinki" => "(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
                                        "Asia/Jerusalem" => "(GMT+02:00) Jerusalem",
                                        "Europe/Minsk" => "(GMT+02:00) Minsk",
                                        "Africa/Windhoek" => "(GMT+02:00) Windhoek",
                                        "Asia/Kuwait" => "(GMT+03:00) Kuwait, Riyadh, Baghdad",
                                        "Europe/Moscow" => "(GMT+03:00) Moscow, St. Petersburg, Volgograd",
                                        "Africa/Nairobi" => "(GMT+03:00) Nairobi",
                                        "Asia/Tbilisi" => "(GMT+03:00) Tbilisi",
                                        "Asia/Tehran" => "(GMT+03:30) Tehran",
                                        "Asia/Muscat" => "(GMT+04:00) Abu Dhabi, Muscat",
                                        "Asia/Baku" => "(GMT+04:00) Baku",
                                        "Asia/Yerevan" => "(GMT+04:00) Yerevan",
                                        "Asia/Kabul" => "(GMT+04:30) Kabul",
                                        "Asia/Yekaterinburg" => "(GMT+05:00) Yekaterinburg",
                                        "Asia/Karachi" => "(GMT+05:00) Islamabad, Karachi, Tashkent",
                                        "Asia/Calcutta" => "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
                                        "Asia/Calcutta" => "(GMT+05:30) Sri Jayawardenapura",
                                        "Asia/Katmandu" => "(GMT+05:45) Kathmandu",
                                        "Asia/Almaty" => "(GMT+06:00) Almaty, Novosibirsk",
                                        "Asia/Dhaka" => "(GMT+06:00) Astana, Dhaka",
                                        "Asia/Rangoon" => "(GMT+06:30) Yangon (Rangoon)",
                                        "Asia/Bangkok" => "(GMT+07:00) Bangkok, Hanoi, Jakarta",
                                        "Asia/Krasnoyarsk" => "(GMT+07:00) Krasnoyarsk",
                                        "Asia/Hong_Kong" => "(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
                                        "Asia/Kuala_Lumpur" => "(GMT+08:00) Kuala Lumpur, Singapore",
                                        "Asia/Irkutsk" => "(GMT+08:00) Irkutsk, Ulaan Bataar",
                                        "Australia/Perth" => "(GMT+08:00) Perth",
                                        "Asia/Taipei" => "(GMT+08:00) Taipei",
                                        "Asia/Tokyo" => "(GMT+09:00) Osaka, Sapporo, Tokyo",
                                        "Asia/Seoul" => "(GMT+09:00) Seoul",
                                        "Asia/Yakutsk" => "(GMT+09:00) Yakutsk",
                                        "Australia/Adelaide" => "(GMT+09:30) Adelaide",
                                        "Australia/Darwin" => "(GMT+09:30) Darwin",
                                        "Australia/Brisbane" => "(GMT+10:00) Brisbane",
                                        "Australia/Canberra" => "(GMT+10:00) Canberra, Melbourne, Sydney",
                                        "Australia/Hobart" => "(GMT+10:00) Hobart",
                                        "Pacific/Guam" => "(GMT+10:00) Guam, Port Moresby",
                                        "Asia/Vladivostok" => "(GMT+10:00) Vladivostok",
                                        "Asia/Magadan" => "(GMT+11:00) Magadan, Solomon Is., New Caledonia",
                                        "Pacific/Auckland" => "(GMT+12:00) Auckland, Wellington",
                                        "Pacific/Fiji" => "(GMT+12:00) Fiji, Kamchatka, Marshall Is.",
                                        "Pacific/Tongatapu" => "(GMT+13:00) Nuku'alofa",
                                    );
                                    echo '<select name="time_zone" class="form-control">';
                                    $time_zone = isset($data['time_zone']) ? $data['time_zone'] : '';
                                    foreach ($timezones as $key => $value) {
                                        $selected = $time_zone == $key ? 'selected="selected"' : '';
                                        echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    $currency_list = array(
                                        "USD" => "United States Dollars (USD)",
                                        "EUR" => "Euro (EUR)",
                                        "GBP" => "United Kingdom Pounds (GBP)",
                                        "DZD" => "Algeria Dinars (DZD)",
                                        "ARP" => "Argentina Pesos (ARP)",
                                        "AUD" =>  "Australia Dollars (AUD)",
                                        "ATS" => "Austria Schillings (ATS)",
                                        "BSD" => "Bahamas Dollars (BSD)",
                                        "BBD" => "Barbados Dollars (BBD)",
                                        "BEF" => "Belgium Francs (BEF)",
                                        "BMD" => "Bermuda Dollars (BMD)",
                                        "BRR" => "Brazil Real (BRR)",
                                        "BGL" => "Bulgaria Lev (BGL)",
                                        "CAD" => "Canada Dollars (CAD)",
                                        "CLP" => "Chile Pesos (CLP)",
                                        "CNY" => "China Yuan Renmimbi (CNY)",
                                        "CYP" => "Cyprus Pounds (CYP)",
                                        "CSK" => "Czech Republic Koruna (CSK)",
                                        "DKK" => "Denmark Kroner (DKK)",
                                        "NLG" => "Dutch Guilders (NLG)",
                                        "XCD" => "Eastern Caribbean Dollars (XCD)",
                                        "EGP" => "Egypt Pounds (EGP)",
                                        "FJD" => "Fiji Dollars (FJD)",
                                        "FIM" => "Finland Markka (FIM)",
                                        "FRF" => "France Francs (FRF)",
                                        "DEM" => "Germany Deutsche Marks (DEM)",
                                        "XAU" => "Gold Ounces (XAU)",
                                        "GRD" => "Greece Drachmas (GRD)",
                                        "HKD" => "Hong Kong Dollars (HKD)",
                                        "HUF" => "Hungary Forint (HUF)",
                                        "ISK" => "Iceland Krona (ISK)",
                                        "INR" => "India Rupees (INR)",
                                        "IDR" => "Indonesia Rupiah (IDR)",
                                        "IEP" => "Ireland Punt (IEP)",
                                        "ILS" => "Israel New Shekels (ILS)",
                                        "ITL" => "Italy Lira (ITL)",
                                        "JMD" => "Jamaica Dollars (JMD)",
                                        "JPY" => "Japan Yen (JPY)",
                                        "JOD" => "Jordan Dinar (JOD)",
                                        "KRW" => "Korea (South) Won (KRW)",
                                        "LBP" => "Lebanon Pounds (LBP)",
                                        "LUF" => "Luxembourg Francs (LUF)",
                                        "MYR" => "Malaysia Ringgit (MYR)",
                                        "MXP" => "Mexico Pesos (MXP)",
                                        "NLG" => "Netherlands Guilders (NLG)",
                                        "NZD" => "New Zealand Dollars (NZD)",
                                        "NOK" => "Norway Kroner (NOK)",
                                        "PKR" => "Pakistan Rupees (PKR)",
                                        "XPD" => "Palladium Ounces (XPD)",
                                        "PHP" => "Philippines Pesos (PHP)",
                                        "XPT" => "Platinum Ounces (XPT)",
                                        "PLZ" => "Poland Zloty (PLZ)",
                                        "PTE" => "Portugal Escudo (PTE)",
                                        "ROL" => "Romania Leu (ROL)",
                                        "RUR" => "Russia Rubles (RUR)",
                                        "SAR" => "Saudi Arabia Riyal (SAR)",
                                        "XAG" => "Silver Ounces (XAG)",
                                        "SGD" => "Singapore Dollars (SGD)",
                                        "SKK" => "Slovakia Koruna (SKK)",
                                        "ZAR" => "South Africa Rand (ZAR)",
                                        "KRW" => "South Korea Won (KRW)",
                                        "ESP" => "Spain Pesetas (ESP)",
                                        "XDR" => "Special Drawing Right (IMF) (XDR)",
                                        "SDD" => "Sudan Dinar (SDD)",
                                        "SEK" => "Sweden Krona (SEK)",
                                        "CHF" => "Switzerland Francs (CHF)",
                                        "TWD" => "Taiwan Dollars (TWD)",
                                        "THB" => "Thailand Baht (THB)",
                                        "TTD" => "Trinidad and Tobago Dollars (TTD)",
                                        "TRL" => "Turkey Lira (TRL)",
                                        "VEB" => "Venezuela Bolivar (VEB)",
                                        "ZMK" => "Zambia Kwacha (ZMK)",
                                        "EUR" => "Euro (EUR)",
                                        "XCD" => "Eastern Caribbean Dollars (XCD)",
                                        "XDR" => "Special Drawing Right (IMF) (XDR)",
                                        "XAG" => "Silver Ounces (XAG)",
                                        "XAU" => "Gold Ounces (XAU)",
                                        "XPD" => "Palladium Ounces (XPD)",
                                        "XPT" => "Platinum Ounces (XPT)",
                                    );
                                    echo '<select name="currency" class="form-control">';
                                    $currency = isset($data['currency']) ? $data['currency'] : '';
                                    foreach ($currency_list as $key => $value) {
                                        $selected = $currency == $key ? 'selected="selected"' : '';
                                        echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                                <div class="d-none">
                                <hr>
                                <h3>Order Format</h3>
                                <div class="col-md-6">
                                    <input type="text" name="order_prefix" value="<?php echo isset($data['order_prefix']) ? $data['order_prefix'] : ''; ?>" placeholder="Prefix" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="order_suffix" value="<?php echo isset($data['order_suffix']) ? $data['order_suffix'] : ''; ?>" placeholder="Suffix" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <span>Order number starts at #1001 by default. While you can't change the order number itself, you can add prefix or suffix to create IDs like "PB1001" or "1001-PB."</span>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script>
    $(document).ready(function() {
        $('.btn-submit').click(function() {
            $('[name="form-add"]').submit();
        });

        $('[name="form-add"]').submit(function() {
            $('.custom-validation-message').remove();
            $('.btn-submit').find('.spinner-border').removeClass('d-none');
            $('.btn-submit').attr('disabled', 'disabled');
            $.ajax({
                url: BASE_URL + '/settings/general',
                type: 'POST',
                data: $('[name="form-add"]').serialize(),
                dataType: 'json',
                success: function(response) {
                    $('.btn-submit').find('.spinner-border').addClass('d-none');
                    $('.btn-submit').removeAttr('disabled');
                    if (response.status) {
                        toastr.success(response.message);
                    } else {
                        if (typeof response.message == 'object') {
                            $.each(response.message, function(index, message) {
                                $('<p class="text-danger custom-validation-message">' + message + '</p>').insertAfter('[name="' + input + '"]');
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(reject) {
                    $('.btn-submit').find('.spinner-border').addClass('d-none');
                    $('.btn-submit').removeAttr('disabled');
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function(input, val) {
                            $('<p class="text-danger custom-validation-message">' + val[0] + '</p>').insertAfter('[name="' + input + '"]');
                        });
                    }
                }
            });
        });
    });
</script>
@endsection