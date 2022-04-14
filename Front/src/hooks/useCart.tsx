import { useEffect, useState } from "react";
import { endpoint, ProductModel } from "../App";

const useCart = () => {
  const [loading, setLoading] = useState<boolean>(true);
  const [products, setProducts] = useState<ProductModel[]>([]);
  const [message, setMessage] = useState<string | null>(null);

  const loadCart = () => {
    return new Promise((resolve) => {
      fetch(`${endpoint}/cart`)
        .then((res) => res.json())
        .then((res) => {
          setLoading(false);
          setProducts(res.products);
          resolve(true);
        });
    });
  };

  useEffect(() => {
    loadCart();
  }, []);

  const removeToCart = (product: ProductModel) => {
    return new Promise((resolve) => {
      setLoading(true);
      fetch(`${endpoint}/cart/${product.id}`, {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        method: "DELETE",
      })
        .then((res) => res.json())
        .then((res) => {
          setMessage("Produit bien supprimé");
          loadCart().then(resolve);
        });
    });
  };

  return {
    loading,
    products,
    message,
    loadCart,
    removeToCart,
  };
};

export default useCart;
