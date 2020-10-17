<template>
  <b-form>
    <b-row>
      <b-col>
        <b-form-group label="Tài khoản:">
          <b-form-input id="input-1" name="username" v-model="text" required placeholder="Nhập tài khoản"></b-form-input>
        </b-form-group>

        <b-form-group label="Mật khẩu:">
          <b-form-input id="input-password" name="password" v-model="text" type="password" required placeholder="Nhập mật khẩu"></b-form-input>
        </b-form-group>

        <b-form-group label="Xác nhận lại mật khẩu:">
          <b-form-input id="input-password_2" name="password" v-model="text" type="password" required placeholder="Nhập mật khẩu"></b-form-input>
        </b-form-group>

        <label for="input-4">Ngày sinh:</label>
        <b-form-datepicker id="input-birthday" name="birthday"></b-form-datepicker>
      </b-col>
      <b-col>
        <b-form-group label="Họ và tên:">
          <b-form-input id="input-fullName" name="fullName" v-model="text" required placeholder="Nhập họ tên"></b-form-input>
        </b-form-group>

        <b-form-group label="Giới tính:">
          <b-form-radio-group>
            <b-form-radio id="radio-gender-male" v-model="selected" name="gender" value="A">Nam</b-form-radio>
            <b-form-radio id="radio-gender-female" v-model="selected" name="gender" value="B">Nữ</b-form-radio>
          </b-form-radio-group>
        </b-form-group>

        <b-form-group label="Tài khoản email:">
          <b-form-input id="input-email" name="email" v-model="text" type="email" required placeholder="Nhập email"></b-form-input>
        </b-form-group>

        <b-form-group label="Số điện thoại:">
          <b-form-input id="input-phone" name="phone" required placeholder="Nhập số điện thoại"></b-form-input>
        </b-form-group>
      </b-col>
    </b-row>

    <b-row>
      <b-col>
        <b-form-group label="Địa chỉ:">
          <b-form-textarea id="input-address" name="address" v-model="text" placeholder="Nhập địa chỉ" rows="3" max-rows="6"></b-form-textarea>
        </b-form-group>
      </b-col>
    </b-row>

    <b-raw class="text-center">
      <b-col>
        <b-button type="submit" variant="success">Đăng ký</b-button>
      </b-col>
    </b-raw>
  </b-form>
</template>
