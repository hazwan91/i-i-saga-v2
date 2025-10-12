import { router, usePage } from '@inertiajs/vue3';

/** Allowed HTTP methods for Inertia visits */
export type VisitMethod = 'get' | 'post' | 'put' | 'patch' | 'delete';

/** Options for route.visit() */
export interface VisitOptions {
    /** Optional custom path. Defaults to current path */
    path?: string;
    /** Optional query parameters to merge */
    query?: Record<string, any>;
    /** HTTP method, defaults to 'get' */
    method?: VisitMethod;
    /** Optional Inertia visit options */
    options?: Record<string, any>;
}

/**
 * Global route helper, similar to Ziggy
 */
export const routeHelper = {
    /** Get current full URL (including query string) */
    url(): string {
        return usePage().url;
    },

    /** Get current path without query string */
    path(): string {
        return this.url().split('?')[0];
    },

    /** Get current query parameters as an object */
    query(): Record<string, string> {
        return Object.fromEntries(new URLSearchParams(window.location.search));
    },

    /**
     * Check if current path matches pattern (supports wildcard '*')
     * @param pattern e.g. '/users*'
     */
    is(pattern: string): boolean {
        const path = this.path();
        const regex = new RegExp('^' + pattern.replace('*', '.*') + '$');
        return regex.test(path);
    },

    /**
     * Merge current query with new query parameters
     * @param newQuery object of query params
     * @param customPath optional path to merge with (default: current path)
     * @returns URL string
     */
    mergeQuery(
        newQuery: Record<string, any> = {},
        customPath?: string,
    ): string {
        const path = customPath || this.path();
        const merged = { ...this.query(), ...newQuery };
        const qs = new URLSearchParams(merged).toString();
        return `${path}${qs ? '?' + qs : ''}`;
    },

    /**
     * Navigate to a URL with optional query, custom path, HTTP method, and Inertia options
     * @param options VisitOptions object
     */
    visit({
        path,
        query = {},
        method = 'get',
        options = {},
    }: VisitOptions = {}): void {
        const pathToUse = path || this.path();
        router.visit(this.mergeQuery(query, pathToUse), { method, ...options });
    },
};
