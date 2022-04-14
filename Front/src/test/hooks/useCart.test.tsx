import {rest} from "msw";
import {setupServer} from "msw/node";
import { renderHook, act } from '@testing-library/react-hooks'
import useCart from "../../hooks/useCart";

const server = setupServer(
    rest.get(
        "http://localhost:8000/api/cart",
        (req, res, ctx) => {
            return res(
                ctx.json({
                    products: [{
                        id: 3,
                        name: 'Summer Smith',
                        price: '15',
                        quantity: 5,
                        image: 'https://rickandmortyapi.com/api/character/avatar/3.jpeg'
                    },
                        {
                            id: 15,
                            name: 'Alien Rick',
                            price: '20',
                            quantity: 20,
                            image: 'https://rickandmortyapi.com/api/character/avatar/15.jpeg'
                        },
                        {
                            id: 15,
                            name: 'Alien Rick',
                            price: '20',
                            quantity: 20,
                            image: 'https://rickandmortyapi.com/api/character/avatar/15.jpeg'
                        }
                ]}))}),
    // remove
    rest.delete("http://localhost:8000/api/cart/3",(req,res,ctx) => {
                return res(ctx.json({
                    products: [
                        {
                            id: 15,
                            name: 'Alien Rick',
                            price: '20',
                            quantity: 20,
                            image: 'https://rickandmortyapi.com/api/character/avatar/15.jpeg'
                        },
                        {
                            id: 15,
                            name: 'Alien Rick',
                            price: '20',
                            quantity: 20,
                            image: 'https://rickandmortyapi.com/api/character/avatar/15.jpeg'
                        }
                ]
                }))
    })
    );

beforeAll(() => server.listen());
afterEach(() => server.resetHandlers());
afterAll(() => server.close());

    test("load cart", async () => {
        const {result} = renderHook(() => useCart());
        const {loading, loadCart} = result.current;
        expect(loading).toEqual(true);
        await act(async () => {
            await loadCart()
        });
        const {products} = result.current;
        expect(products.length).toEqual(3);
    })

    test("remove cart", async () => {
        const {result} = renderHook(() => useCart());
        const {loading, removeToCart} = result.current;
        expect(loading).toEqual(true);
        await act(async () => {
            await removeToCart({
                id: 3,
                name: 'Summer Smith',
                price: '15',
                quantity: 5,
                image: ''
            })
        });

        expect(result.current.loading).toBeFalsy();
        expect(result.current.message).toStrictEqual("Produit bien supprimé");

        // # : removeToCart calls loadCart At the end so the mock data is reset.
        expect(result.current.products.length).toEqual(3);
    })