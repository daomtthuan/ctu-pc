import { VNode } from 'vue';

declare module 'vue/types/vue' {
  interface Vue {
    data?(): object;
    fetch?(): void | Promise<void>;
    beforeCreate?(): void | Promise<void>;
    created?(): void | Promise<void>;
    beforeMount?(): void | Promise<void>;
    mounted?(): void | Promise<void>;
    beforeDestroy?(): void | Promise<void>;
    destroyed?(): void | Promise<void>;
    beforeUpdate?(): void | Promise<void>;
    updated?(): void | Promise<void>;
    activated?(): void | Promise<void>;
    deactivated?(): void | Promise<void>;
    render?(createElement: CreateElement): VNode;
    errorCaptured?(err: Error, vm: Vue, info: string): boolean | undefined;
    serverPrefetch?(): Promise<unknown>;
  }
}
