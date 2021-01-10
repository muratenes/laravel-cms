<div id="differentInvoiceAddress" style="display: none">
    <input type="hidden" name="type" value="{{ \App\Models\KullaniciAdres::TYPE_INVOICE }}">
    <input type="hidden" name="fromPage" id="fromPage" value="odeme.adres">
    <div class="row no-gutters">
        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="address-company-name">Adres Başlığı</label>
                    <input type="text" class="form-control"  name="title" placeholder="Örnek : Evim" value="{{ old('title') }}">
                </div>
                <div class="form-group col-md-6 mb-0">
                    <label for="address-phone">Telefon Numarası</label>
                    <input type="text" class="form-control" id="address-phone" placeholder="531 111 11 11" name="phone" maxlength="20" value="{{ old('phone',$user->phone)}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6"><label for="address-first-name">Ad</label>
                    <input type="text" class="form-control" id="address-first-name" name="name" placeholder="Adınız" value="{{ old('name',$user->name)}}"  maxlength="50">
                </div>
                <div class="form-group col-md-6"><label for="address-last-name">Soyad</label>
                    <input type="text" name="surname" class="form-control" id="address-last-name" placeholder="Soyad" value="{{ old('surname',$user->surname)}}"  maxlength="50">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6"><label>İl</label>
                    <select class="form-control form-control-select2" name="state_id"  onchange="citySelectOnChange(this)">
                        <option value="">-- il seçiniz --</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}">
                                {{ $state->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6"><label>İlçe</label>
                    <select class="form-control form-control-select2"  name="district_id" id="district">
                        <option value="">-- ilçe seçiniz --</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="address-address1">Adres</label>
                <textarea type="text" class="form-control" id="address-address1"  placeholder="Sokak,Mahalle,Bina Daire Numarası" required name="adres" >{{ old('adres') }}</textarea>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 mb-0">
                    <label for="address-email">Email</label>
                    <input type="email" class="form-control" id="address-email" placeholder="user@site.com" name="email" value="{{ old('email',$user->email) }}"  >
                </div>
            </div>
        </div>
    </div>

</div>
