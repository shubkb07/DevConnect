import type { NextConfig } from "next";
import { config } from 'dotenv';

// Load .env file only in non-production environments
if (process.env.NODE_ENV !== 'production') {
  config();
}

const nextConfig: NextConfig = {
  /* config options here */
};

export default nextConfig;
