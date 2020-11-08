<template>
  <b-card-body>
    <b-card-title title-tag="h2" class="text-primary">
      Chính Sách Bảo Hành
    </b-card-title>
    <hr />
    <h5>Quy định về bảo hành</h5>
    <h6>Sản phẩm lỗi do nhà sản xuất:</h6>
    <ul>
      <li>CTU PC SHOP bảo hành theo tiêu chuẩn của hãng. Thời gian bảo hành trong vòng 7 ngày làm việc (không tính Thứ 7, Chủ Nhật).</li>
    </ul>
    <h6>Sản phẩm lỗi do người sử dụng:</h6>
    <ul>
      <li>CTU PC SHOP có thể nhận hỗ trợ sửa chữa, thay thế tùy trường hợp cụ thể (khách hàng chịu phí sửa chữa nếu có phát sinh).</li>
      <li>CTU PC SHOP có quyền từ chối bảo hành và trả sản phẩm lỗi do người sử dụng đó lại cho khách hàng.</li>
    </ul>
    <h5>Thông tin làm việc của Phòng Bảo Hành CTU PC SHOP</h5>
    <ul>
      <li>Hotline : xxxx xxxx xxx – nhánh số xxx</li>
      <li>Email : xxxxxxxxx@xxxxx.xxx</li>
      <li>Thời gian nhận, trả bảo hành : 10:00 – 18:00 các ngày làm việc trong tuần (trừ Chủ Nhật).</li>
    </ul>
    <h5>Điều kiện nhận bảo hành sản phẩm (áp dụng với sản phẩm bị lỗi do nhà sản xuất)</h5>
    <ul>
      <li>Sản phẩm còn trong thời gian bảo hành của CTU PC SHOP.</li>
      <li>Sản phẩm được dán tem bảo hành chính hãng và CTU PC SHOP.</li>
      <li>Tem bảo hành không bị mờ, rách.</li>
      <li>Số Series Number (S/N), mã vạch sản phẩm phải còn nguyên vẹn.</li>
      <li>Sản phẩm không bị biến dạng vật lý như trầy, xước, lồi, lõm, móp, méo, nứt, vỡ do bị rơi, bị va đập, do vận chuyển/ lắp đặt sai quy cách.</li>
      <li>Sản phẩm không bị mốc, hoen rỉ, ẩm ướt, chất lỏng xâm nhập, ố vàng, mờ chữ, viết chữ không tẩy được</li>
      <li>Sản phẩm không bị chuột, gián bọ, côn trùng xâm nhập…</li>
      <li>Sản phẩm không bị người sử dụng tự ý tháo gỡ, sửa chữa, mất tem niêm phong của nhà sản xuất…</li>
    </ul>
    <h5>Chính sách hỗ trợ khách hàng</h5>
    <ul>
      <li>
        Sticker “GOLD WARRANTY 6 MONTHS”: Sản phẩm được CTU PC SHOP bán ra có dán sticker “Gold Warranty 6 months” sẽ được đổi mới ngay lập tức trong vòng 6 tháng đầu tiên từ ngày mua hàng nếu phát sinh lỗi (Khách hàng cần giữ nguyên vẹn
        hộp và phụ kiện đi kèm sản phẩm).
      </li>
      <li>
        Đổi mới ngay lập tức sản phẩm lỗi (áp dụng trong vòng 7 ngày đầu tiên mua hàng) : Tất cả sản phẩm CTU PC SHOP bán ra đều được hỗ trợ đổi mới ngay lập tức trong vòng 7 ngày đầu tiên mua hàng nếu phát sinh lỗi.
      </li>
      <li>
        Dịch vụ “BẢO HÀNH TẬN NHÀ”: với bộ máy lắp ráp toàn bộ tại CTU PC SHOP sẽ được hỗ trợ dịch vụ đến lấy tận nơi để bảo hành và trả lại tận nơi sau khi bảo hành xong. Dịch vụ được miễn phí trong suốt thời gian bảo hành của máy .
      </li>
      <li>Hỗ trợ phí gửi trả bảo hành đối với khách hàng ở khu vực ngoài TP. Cần Thơ.</li>
    </ul>
  </b-card-body>
</template>
<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'page-guide-policy-warranty',
    head: {
      title: 'Chính sách bảo hành',
    },
  })
  export default class extends Vue {}
</script>
