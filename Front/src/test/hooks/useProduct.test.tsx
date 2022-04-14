import { act, renderHook } from "@testing-library/react-hooks";
import { rest } from "msw";
import { setupServer } from "msw/node";
import useProduct from "../../hooks/useProduct";


const server = setupServer(
    rest.post("http://localhost:8000/api/cart/61",
    (req, res, ctx) => {
        return res(ctx.json({
            "id": 1,
            "products": [
                {
                    "id": 61,
                    "name": "Rick Sanchez",
                    "price": "8",
                    "quantity": 20,
                    "image": "rick's image"
                }
            ]
        }));
    })
);

beforeAll(() => server.listen());
afterEach(() => server.resetHandlers());
afterAll(() => server.close());

test("add product to cart", async ()=>{

    const {result} = renderHook(() => useProduct({
        "id": 61,
        "name": "Rick Sanchez",
        "price": "8",
        "quantity": 20,
        "image": "rick's image"
    }));
    const {loading, addProduct, setQuantity} = result.current;
    expect(loading).toEqual(false);

    await act(async () => {
        await setQuantity(5);
        await addProduct();
    });

    const {message, loading: afterLoading} = result.current;

    expect(message).toEqual("Enregistré dans le panier");
    expect(afterLoading).toBeFalsy();
})