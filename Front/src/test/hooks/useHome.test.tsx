import { renderHook } from "@testing-library/react-hooks";
import {rest} from "msw";
import {setupServer} from "msw/node";
import { act } from "react-dom/test-utils";
import useHome from "../../hooks/useHome";


const server = setupServer(
    rest.get("http://localhost:8000/api/products",
    (req, res, ctx) => {
        return res(
            ctx.json([
                {id:61,name:"Rick Sanchez",price:"8",quantity:20,image:"image 3"},
                {id:62,name:"Morty Smith",price:"16.50",quantity:70,image:"image 2"},
                {id:63,name:"Summer Smith",price:"8",quantity:5,image:"image 1"}
            ]
            ));
        })
);

beforeAll(() => server.listen());
afterEach(() => server.resetHandlers());
afterAll(() => server.close());

test("load products", async ()=>{
    
    const { result } = renderHook(() => useHome());
    const {loading, loadProducts } = result.current;
    expect(loading).toBeTruthy();

    await act(async () => {
        await loadProducts();
    });

    const { products, loading: afterLoading } = result.current;

    expect(afterLoading).toBeFalsy();
    expect(products.length).toEqual(3);
})