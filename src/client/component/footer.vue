<template>
  <div class="bg-light border-primary border-top pt-3">
    <b-container :fluid="fluid">
      <div class="text-center">
        <c-logo :size="64"></c-logo>
        <h3 class="text-primary my-1 font-weight-bold">CTU PC SHOP</h3>
        <h5>Cửa hàng máy tính trường Đại học Cần Thơ</h5>
      </div>
      <hr />
      <b-row>
        <b-col lg="4" md="6">
          <h5>Chính sách - Hướng dẫn</h5>
          <ul>
            <li><b-link to="/guide-policy/payment">Hướng dẫn thanh toán</b-link></li>
            <li><b-link to="/guide-policy/installment">Hướng dẫn trả góp</b-link></li>
            <li><b-link to="/guide-policy/shipping">Chính sách vận chuyển</b-link></li>
            <li><b-link to="/guide-policy/warranty">Chính sách bảo hành</b-link></li>
          </ul>
          <h5>Sự kiện</h5>
          <ul>
            <div v-for="event in events" :key="event.id">
              <li>
                <div class="text-truncate">
                  <nuxt-link :to="`/event/${event.id}`">{{ event.title }}</nuxt-link>
                </div>
              </li>
            </div>
          </ul>
        </b-col>
        <b-col lg="4" md="6">
          <h5>Địa chỉ</h5>
          <ul>
            <li>
              <b>Chi nhánh 1:</b><br />
              xx, xxxx, xxx xxxx, xxxx, xxxx
            </li>
            <li>
              <b>Chi nhánh 2:</b><br />
              xx, xxxx, xxx xxxx, xxxx, xxxx
            </li>
          </ul>
          <h5>Liên hệ</h5>
          <ul>
            <li>
              <b>Hotline:</b><br />
              xxxx xxx xxxx, nhánh số xx
            </li>
            <li>
              <b>Bảo hành:</b><br />
              xxxx xxx xxxx, nhánh số xx
            </li>
          </ul>
        </b-col>
        <b-col lg="4">
          <h5>Bản đồ</h5>
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.83143477373!2d105.7689214!3d10.0307651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0883d2192b0f1%3A0x4c90a391d232ccce!2zS2hvYSBDw7RuZyBOZ2jhu4cgVGjDtG5nIFRpbiB2w6AgVHJ1eeG7gW4gVGjDtG5nIChDVFUp!5e0!3m2!1svi!2s!4v1605094824562!5m2!1svi!2s"
            frameborder="0"
            class="d-block w-100 border"
            :style="{ height: 'calc(100% - 32px)' }"
            allowfullscreen="true"
            aria-hidden="false"
            tabindex="0"
          ></iframe>
        </b-col>
      </b-row>
      <hr />
      <p class="text-center">
        <em>
          Sản phẩm này chỉ phục vụ cho hoạt động học tập và nghiên cứu, không phục vụ cho mục đích thương mại<br />
          Bản quyền mã nguồn mở,
          <b-link href="https://github.com/daomtthuan/ctu-pc-shop/blob/master/LICENSE">MIT License, Copyright (c) 2020 Daomtthuan</b-link>
        </em>
      </p>
    </b-container>
  </div>
</template>

<script lang="ts">
  import { Component, Prop, Vue } from 'nuxt-property-decorator';

  @Component({
    name: 'component-footer',
  })
  export default class extends Vue {
    @Prop({ type: Boolean, default: true })
    private fluid!: boolean;

    @Prop({ type: Array, required: true })
    private events!: Entity.Event[];
  }
</script>
