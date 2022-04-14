import {rest} from "msw";
import {setupServer} from "msw/node";


const server = setupServer(
    rest.get("http://localhost:8000/api/products",
    (req, res, ctx) => {
        return res(
            ctx.json({

            }));
        })
);

beforeAll(() => server.listen());
afterEach(() => server.resetHandlers());
afterAll(() => server.close());

test("test load products", async ()=>{
    
    expect(true).toBeTruthy();
})