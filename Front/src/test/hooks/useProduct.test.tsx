import { setupServer } from "msw/lib/types/node";


const server = setupServer();

beforeAll(() => server.listen());
afterEach(() => server.resetHandlers());
afterAll(() => server.close());

test("test add product", async ()=>{

    expect(true).toBeTruthy();
})