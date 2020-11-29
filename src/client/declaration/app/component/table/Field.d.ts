declare namespace App {
  namespace Component {
    namespace Table {
      interface Field {
        key: string;
        label?: string;
        sortable?: boolean;
        class?: string;
        formatter?: (value: any, key: string, item: object) => any;
        sortByFormatted?: boolean;
        filterByFormatted?: boolean;
      }
    }
  }
}
