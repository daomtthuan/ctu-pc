<script lang="ts">
  import { Component, mixins, Prop, Vue } from 'nuxt-property-decorator';
  import { Line } from 'vue-chartjs';

  @Component({
    name: 'component-chart-area',
  })
  export default class extends mixins(Line) {
    @Prop({ type: String, required: true })
    private label!: string;

    @Prop({ type: Array, required: true })
    private value!: number[];

    private gradient: any = null;

    public mounted() {
      let context = (<HTMLCanvasElement>this.$refs.canvas).getContext('2d');
      if (context) {
        this.gradient = context.createLinearGradient(0, 0, 0, 450);

        this.gradient.addColorStop(0, '#3b84c080');
        this.gradient.addColorStop(0.5, '#3b84c040');
        this.gradient.addColorStop(1, '#3b84c000');

        let labels = [];
        for (let month = 1; month <= 12; month++) {
          labels.push(month);
        }

        this.renderChart(
          {
            labels: labels,
            datasets: [
              {
                label: this.label,
                borderColor: '#3b84c0',
                pointBackgroundColor: '#fafafa',
                borderWidth: 1,
                pointBorderColor: '#fafafa',
                backgroundColor: this.gradient,
                data: this.value,
              },
            ],
          },
          { responsive: true, maintainAspectRatio: false }
        );
      }
    }
  }
</script>
