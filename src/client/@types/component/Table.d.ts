declare namespace Table {
  interface Field {
    key: string;
    label: string;
    sortable?: boolean;
    class?: string;
    formatter?: (value: any, key: string, item: object) => any;
  }

  interface Note {
    label: string;
    class: string;
  }
}
