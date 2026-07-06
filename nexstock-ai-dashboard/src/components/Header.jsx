import { Zap } from 'lucide-react';

export default function Header() {
  return (
    <header className="flex flex-col md:flex-row items-center justify-between py-6 border-b border-[var(--border)] mb-8">
      <div>
        <h1 className="text-2xl font-bold tracking-tight text-white">NexStock AI</h1>
        <p className="text-sm text-gray-400">Accelerated Inventory Intelligence</p>
      </div>
      
      <div className="mt-4 md:mt-0 flex items-center gap-2 bg-indigo-500/10 text-indigo-400 px-4 py-2 rounded-full border border-indigo-500/20 shadow-[0_0_15px_rgba(99,102,241,0.15)]">
        <Zap className="w-4 h-4 text-indigo-400" />
        <span className="text-sm font-medium tracking-wide">
          Live: <strong className="text-white">1.5M</strong> transaction rows processed in <strong className="text-white">0.8s</strong> via NVIDIA cuDF
        </span>
      </div>
    </header>
  );
}
