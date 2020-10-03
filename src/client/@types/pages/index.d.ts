declare namespace App {
  export namespace Pages {
    export namespace Index {
      export interface Navigation {
        [key: string]: {
          title: string;
          subNavigation?: Navigation;
        };
      }
    }
  }
}
