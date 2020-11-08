<template>
  <b-card-body>
    <b-card-title title-tag="h2" class="text-primary">
      Phương thức thanh toán
    </b-card-title>
    <hr />
    <ol>
      <li>Quý khách có thể thanh toán bằng tiền mặt hoặc quẹt thẻ ngân hàng. (Miễn phí quẹt thẻ ATM nội địa với đơn hàng dưới 10 triệu)</li>
      <li>Nhân viên thu ngân sẽ trực tiếp hướng dẫn quý khách hàng thanh toán đơn hàng.</li>
      <li>Ngay sau khi tiến hành thanh toán, quý khách hàng sẽ được nhân viên kinh doanh hướng dẫn kiểm tra và nhận hàng.</li>
    </ol>
    <h5>Thanh toán trực tiếp tại CTU PC SHOP</h5>
    <ol>
      <li>
        Quý khách hàng thanh toán tiền mặt hoặc chuyển khoản ngân hàng số tiền tương ứng với đơn hàng. Có thể phát sinh thêm phí vận chuyển nếu địa điểm không nằm trong phạm vi giao hàng miễn phí hoặc sử dụng các dịch vụ vận chuyển cộng
        thêm (thông báo trước với quý khách).
      </li>
      <li>Để tránh mất thời gian trong quá trình thanh toán, quý khách hàng có thể chuẩn bị sẵn tiền mặt hoặc chuyển khoản ngân hàng trước.</li>
      <li>
        Quý khách hàng vui lòng kiểm tra lại hàng hóa trước khi thanh toán. Mọi vấn đề phát sinh trong quá trình nhận hàng thanh toán, quý khách vui lòng liên hệ Hotline 0901 343 881 – nhánh 108 để được nhân viên kinh doanh kiểm tra hỗ trợ.
      </li>
      <li>
        Nếu quý khách hàng ở tỉnh ngoài TP. Cần Thơ, quý khách hàng cần chuyển khoản online trước cho CTU PC SHOP, sau khi nhận được tiền, CTU PC SHOP sẽ tiến hành gọi lại xác nhận thông tin giao hàng và làm thủ tục gửi hàng cho quý khách
        hàng.
      </li>
    </ol>
    <h5>Thông tin tài khoản ngân hàng của CTU PC SHOP</h5>
    <h6>Ngân hàng TMCP Ngoại Thương Việt Nam (Vietcombank)</h6>
    <ul>
      <li>Chủ tài khoản: xxx xxx xxxx</li>
      <li>Chi Nhánh TP. Cần Thơ – Phòng Giao Dịch xxx xxxx</li>
      <li>Số tài khoản: xxxxxxxxxx – Số thẻ nội địa: xxxxxxxxxxxxxxxx</li>
    </ul>
    <h6>Ngân Hàng ACB</h6>
    <ul>
      <li>Chủ tài khoản: xxx xxx xxxx</li>
      <li>Chi Nhánh TP. Cần Thơ – Phòng Giao Dịch xxx xxxx</li>
      <li>Số tài khoản: xxxxxxxxxx – Số thẻ nội địa: xxxxxxxxxxxxxxxx</li>
    </ul>
    <h6>Ngân Hàng Sacombank</h6>
    <ul>
      <li>Chủ tài khoản: xxx xxx xxxx</li>
      <li>Chi Nhánh TP. Cần Thơ – Phòng Giao Dịch xxx xxxx</li>
      <li>Số tài khoản: xxxxxxxxxx – Số thẻ nội địa: xxxxxxxxxxxxxxxx</li>
    </ul>
    <p>
      <em>Quý khách lưu ý: nên chuyển cùng ngân hàng để tiết kiệm chi phí chuyển tiền</em>
    </p>
  </b-card-body>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-guide-policy-payment',
    head: {
      title: 'Hướng dẫn thanh toán',
    },
  })
  export default class extends Vue {}
</script>
