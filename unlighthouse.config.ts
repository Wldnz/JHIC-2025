import { defineUnlighthouseConfig } from 'unlighthouse/config'

export default defineUnlighthouseConfig({
    site: 'http://localhost:8000',
    scanner: {
        robotsTxt: false,
        crawler: false,
        exclude: ['/private/*'],
        sitemap: [
            '/sitemap.xml'
        ]
    },
    debug: true,
    lighthouseOptions: {
        maxWaitForFcp: 60 * 1000,
        maxWaitForLoad: 60 * 1000,
    }
})
