<template>
  <b-card-body>
    <b-card-title title-tag="h2" class="text-primary">
      Chính Sách Vận Chuyển
    </b-card-title>
    <hr />
    <h5>Giao hàng trực tiếp</h5>
    <ul>
      <li>Chỉ áp dụng giao hàng trong khu vực TP. Cần Thơ. Trường hợp ngoại tỉnh lân cận TP. Cần Thơ quý khách vui lòng liên hệ bộ phận kinh doanh của CTU PC SHOP thông qua Hotline 0901 343 881 – nhánh 108.</li>
      <li>Miễn phí vận chuyển với đơn hàng trên 500.000 VNĐ (tối đa 10 km). Với phạm vi hơn 10km CTU PC SHOP sẽ thông báo mức phí ship cho quý khách trước khi giao hàng.</li>
      <li>Miễn phí giao hàng tận nơi khi lắp ráp bộ máy tại CTU PC SHOP.</li>
      <li>Ngay khi đặt hàng, quý khách sẽ được CTU PC SHOP liên hệ để xác nhận lại thời gian và địa chỉ giao hàng, cũng như phí ship (nếu có).</li>
    </ul>
    <h5>Giao hàng chuyển phát nhanh</h5>
    <ul>
      <li>Quý khách cần chuyển khoản thanh toán tiền hàng trước cho CTU PC SHOP.</li>
      <li>
        Với hàng hóa kích thước lớn, phí vận chuyển có thể cao hơn dựa trên tính toán quy đổi trọng lượng theo công thức của bên vận chuyển. Mức phí này sẽ được CTU PC SHOP báo với khách hàng xác nhận đồng ý trước khi gửi.
      </li>
      <li>Thời gian giao hàng của dịch vụ này thường từ 24-36 tiếng (1-2 ngày), và được chuyển phát tận nơi theo địa chỉ khách hàng cung cấp cho CTU PC SHOP.</li>
    </ul>
    <h5>Giao hàng qua nhà xe trung gian</h5>
    <ul>
      <li>Quý khách cần chuyển khoản thanh toán tiền hàng trước cho CTU PC SHOP.</li>
      <li>Quý khách cần liên hệ trực tiếp với nhà xe để nhận hàng gửi. (thông tin phiếu gửi hàng sẽ được CTU PC SHOP cung cấp cho quý khách ngay khi tiến hành gửi hàng xong).</li>
    </ul>
    <h5>Chính sách hỗ trợ khách hàng</h5>
    <ul>
      <li>
        Dịch vụ giao hàng hỏa tốc (áp dụng giao hàng trong nội thành) : Quý khách cần check vào nút giao hàng hỏa tốc trên sản phẩm, CTU PC SHOP sẽ chủ động liên hệ và xác nhận giao hàng ngay cho quý khách trong vòng 30 phút từ khi tiếp
        nhận thông tin.
      </li>
      <li>
        Dịch vụ Giao Hàng Miễn Phí Tận Nơi (áp dụng giao hàng trong nội thành TP. Cần Thơ) : CTU PC SHOP giao hàng miễn phí tất cả các quận trong TP. Cần Thơ. CTU PC SHOP sẽ chủ động liên hệ và sắp xếp thời gian giao hàng đến quý khách.
      </li>
      <li>Ưu đãi giao hàng Chuyển Phát Nhanh : Miễn phí toàn bộ với đơn hàng trên 2.000.000đ (tối đa 100.000đ và không áp dụng hình thức COD)</li>
      <li>Ưu đãi giao hàng qua nhà xe : Miễn phí toàn bộ tiền vận chuyển qua nhà xe với đơn hàng trên 5.000.000đ (tối đa 100.000đ và không áp dụng với các sản phẩm đang khuyến mãi).</li>
    </ul>
  </b-card-body>
</template>
<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-guide-policy-shipping',
    head: {
      title: 'Chính sách vận chuyển',
    },
  })
  export default class extends Vue {}
</script>
