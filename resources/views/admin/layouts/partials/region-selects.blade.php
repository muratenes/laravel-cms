<!-- Data --->
@php
    $countries = \App\Models\Region\Country::cachedAll()->toArray();
    $states = isset($states) ?: \App\Models\Region\State::getCachedByColumn('country_id',\App\Models\Region\Country::TURKEY)->toArray();
@endphp

<div class="row">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Bölge Bilgileri</h3>
        </div>
        <div class="box-body">
            <x-select name="country_id" label="Ülke" :options="$countries" width="12" :value="$item->country_id" onchange="countryOnChange(this)" required/>
            <x-select name="state_id" label="Şehir" :options="$states" width="12" :value="$item->state_id" onchange="stateOnChange(this)"/>
            @isset($districts)
                <x-select name="district_id" label="İlce" :options="$districts" width="12" :value="$item->district_id"/>
            @endisset
        </div>
    </div>
</div>
<script>
    $('select[id*="id_country_id"]').select2({
        placeholder: 'Ülke seçiniz'
    });
    $('select[id*="id_state_id"]').select2({
        placeholder: 'Şehir seçiniz'
    });
    $('select[id*="id_district_id"]').select2({
        placeholder: 'İlçe seçiniz'
    });

    function countryOnChange(self) {
        $.ajax({
            url: '/admin/locations/states/' + self.value + '',
            success: function (data) {
                bindStates(data);
            }
        })
    }

    function stateOnChange(self) {
        $.ajax({
            url: '/admin/locations/neighborhoods/' + self.value + '',
            success: function (data) {
                bindDistricts(data);
            }
        })
    }

</script>
