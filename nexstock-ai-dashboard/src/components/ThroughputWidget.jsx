import { Cpu, Server } from 'lucide-react';

export default function ThroughputWidget() {
  return (
    <div className="bg-[var(--card)] border border-[var(--border)] rounded-xl p-6 flex flex-col h-full shadow-sm">
      <div className="mb-6">
        <h3 className="text-lg font-semibold text-white">Data Processing Throughput</h3>
        <p className="text-sm text-gray-400">NVIDIA GPU vs Traditional CPU</p>
      </div>

      <div className="flex-1 flex flex-col justify-center space-y-8">
        
        {/* GPU Bar */}
        <div>
          <div className="flex justify-between items-center mb-2">
            <div className="flex items-center gap-2">
              <Server className="w-5 h-5 text-indigo-400" />
              <span className="font-medium text-white">NVIDIA GPU (cuDF)</span>
            </div>
            <span className="text-indigo-400 font-bold">1.5M rows / 0.8s</span>
          </div>
          <div className="w-full bg-gray-800 rounded-full h-3">
            <div className="bg-gradient-to-r from-indigo-600 to-purple-500 h-3 rounded-full" style={{ width: '100%' }}></div>
          </div>
          <p className="text-xs text-right mt-1 text-gray-500">1,875,000 rows/sec</p>
        </div>

        {/* CPU Bar */}
        <div>
          <div className="flex justify-between items-center mb-2">
            <div className="flex items-center gap-2">
              <Cpu className="w-5 h-5 text-gray-400" />
              <span className="font-medium text-gray-300">Standard CPU (Pandas)</span>
            </div>
            <span className="text-gray-400 font-medium">1.5M rows / 45.2s</span>
          </div>
          <div className="w-full bg-gray-800 rounded-full h-3">
            <div className="bg-gray-500 h-3 rounded-full" style={{ width: '4%' }}></div>
          </div>
          <p className="text-xs text-right mt-1 text-gray-500">33,185 rows/sec</p>
        </div>
      </div>
      
      <div className="mt-6 pt-4 border-t border-[var(--border)] text-center">
        <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-indigo-500/10 text-indigo-400 text-xs font-semibold uppercase tracking-wider">
          <span className="relative flex h-2 w-2">
            <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
            <span className="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
          </span>
          56x Speedup Active
        </span>
      </div>
    </div>
  );
}
